<?php

declare(strict_types=1);

namespace App\Inertia\CatalystExplorer;

use App\Enums\CatalystExplorerQueryParams;
use App\Http\Controllers\Controller;
use App\Models\CatalystExplorer\Fund;
use App\Models\CatalystExplorer\Proposal;
use App\Models\Category;
use App\Models\Tag;
use App\Repositories\FundRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Inertia\Inertia;
use Inertia\Response;
use Meilisearch\Endpoints\Indexes;

class VoterToolController extends Controller
{
    public Fund $fund;

    public $challenges;

    public $search;

    public $searchBuilder;

    protected $currentPage;

    protected $currentFilterGroup;

    protected $filterGroupLimit;

    protected int $limit = 24;

    public $searchGroup = null;

    public $perPage;

    public $proposals;

    public $challengeFilter;

    public $tagsFilter;

    public $categoriesFilter;

    public $taxonomy;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct()
    {
        $this->fund = Fund::where('parent_id', null)->first();
        $this->challenges = app(FundRepository::class)
            ->fundChallenges($this->fund);
    }

    public function index(Request $request): Response
    {
        $this->search = $request->input(CatalystExplorerQueryParams::SEARCH, null);
        $this->limit = (int) $request->input(CatalystExplorerQueryParams::PER_PAGE, 24);
        $this->currentPage = $request->input('p', 1);
        $this->searchGroup = $request->input('fg', null);
        $this->currentFilterGroup = $request->input('fgs', 1);
        $this->filterGroupLimit = $request->input('pfgs', 4);
        $this->challengeFilter = $request->input(CatalystExplorerQueryParams::CHALLENGES, null);
        $this->tagsFilter = $request->input(CatalystExplorerQueryParams::TAGS, null);
        $this->categoriesFilter = $request->input(CatalystExplorerQueryParams::CATEGORIES, null);
        $this->query();

        return Inertia::render('VoterTool', [
            'search' => $this->search,
            'currentPage' => $this->currentPage,
            'perPage' => $this->limit,
            'challenges' => $this->challenges,
            'challengeFilter' => intval($this->challengeFilter),
            'tagsFilter' => $this->tagsFilter,
            'categoriesFilter' => $this->categoriesFilter,
            'proposals' => $this->proposals,
            'fund' => $this->fund,
            'crumbs' => [
                [
                    'label' => 'Funds',
                    'link' => route('catalyst-explorer.funds.index'),
                ],
                [
                    'label' => 'Proposals',
                    'link' => route('catalyst-explorer.proposals'),
                ],
                ['label' => 'Voter Tool'],
            ],
            'filters' => $this->getGroupFilters(),
            'filterPerPage' => intval($this->filterGroupLimit),
            'currentFilter' => $this->searchGroup,
        ]);
    }

    protected function query()
    {
        if (! $this->search && ! $this->searchGroup && ! $this->challengeFilter && ! $this->categoriesFilter && ! $this->tagsFilter) {
            return null;
        }

        $filters = $this->getUserFilters($this->searchGroup);
        if (isset($filters['filters'])) {
            $_options = $filters;
        } elseif ($filters == null) {
            return;
        }

        $this->searchBuilder = Proposal::search(
            $this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }

                $options['attributesToRetrieve'] = [
                    'id',
                    'amount_requested',
                    'amount_received',
                    'currency',
                    'ca_rating',
                    'ratings_count',
                    'slug',
                    'title',
                    'funding_status',
                    'groups.id',
                    'ideascale_link',
                    'yes_votes_count',
                    'no_votes_count',
                    'opensource',
                    'paid',
                    'problem',
                    'project_length',
                    'quickpitch',
                    'solution',
                    'status',
                    'website',
                    'type',
                    'ranking_total',
                    'users.id',
                    'users.name',
                    'users.username',
                    'users.ideascale_id',
                    'users.media.original_url',
                    'users.profile_photo_url',
                    'fund.id',
                    'fund.label',
                    'fund.amount',
                    'fund.status',
                    'challenge.id',
                    'challenge.label',
                    'challenge.amount',
                ];

                if (count($_options['sort']) > 0) {
                    $options['sort'] = $_options['sort'];
                }

                $options['offset'] = (($this->currentPage ?? 1) - 1) * $this->limit;
                $options['limit'] = $this->limit;

                return $index->search($query, $options);
            }
        );

        $response = new Fluent($this->searchBuilder->raw());

        $pagination = new LengthAwarePaginator(
            $response->hits,
            $response->estimatedTotalHits,
            $response->limit,
            $this->currentPage,
            [
                'pageName' => 'p',
            ]
        );

        $this->proposals = $pagination->onEachSide(1)->toArray();
    }

    public function getUserFilters($param)
    {
        $_options = [
            'filters' => ["fund.id = {$this->fund?->id}"],
            'sort' => ['ranking_total:desc'],
        ];

        if ($param == 'firstTimers') {
            $_options['filters'][] = 'users.first_timer = true';
        }

        if ($param == 'oneTimers') {
            $_options['filters'][] = 'users.proposals_count = 1';
        }

        if ($param == 'completedProposals') {
            $_options['filters'][] = 'users.proposals_completed > 0';
            $_options['sort'][] = 'users.proposals_completed:asc';
        }

        if ($param == 'below75k') {
            $_options['filters'][] = 'amount_requested <= 75000';
        }

        if ($param == 'over250K') {
            $_options['filters'][] = 'amount_requested >= 250000';
        }

        if ($param == 'mediumProposals') {
            $_options['filters'][] = '(amount_requested 75000 TO 250000)';
        }

        if ($param == 'impactProposals') {
            $_options['filters'][] = 'impact_proposal = 1';
        }

        if ($param == 'quickPitchProposals') {
            $_options['filters'][] = 'quickpitch IS NOT NULL';
        }

        if ($param == 'ideafestProposals') {
            $_options['filters'][] = 'ideafest_proposal = 1';
        }

        if ($param == 'womanProposals') {
            $_options['filters'][] = 'woman_proposal = 1';
        }

        if ($param == 'opensource') {
            $_options['filters'][] = 'opensource = 1';
        }

        if ($this->challengeFilter) {
            $_options['filters'][] = "challenge.id = {$this->challengeFilter}";
        }

        if ($this->tagsFilter) {
            $_options['filters'][] = "tags.id = {$this->tagsFilter}";
        }

        if ($this->categoriesFilter) {
            $_options['filters'][] = "categories.id = {$this->categoriesFilter}";
        }

        return $_options;
    }

    public function getGroupFilters()
    {
        $filters = collect(
            [
                [
                    'title' => 'Quick Pitches',
                    'description' => 'Proposals with Quick Pitches.',
                    'param' => 'quickPitchProposals',
                    'count' => null,
                ],
                [
                    'title' => 'Completed Proposals',
                    'description' => 'From teams with completed Proposals',
                    'param' => 'completedProposals',
                    'count' => null,
                ],
                [
                    'title' => 'Opensource',
                    'description' => 'Opensource projects',
                    'param' => 'opensource',
                    'count' => null,
                ],
                [
                    'title' => 'Ideafest Proposals',
                    'description' => 'Projects presented at Ideafest!',
                    'param' => 'ideafestProposals',
                    'count' => null,
                ],
                [
                    'title' => 'Impact Proposals',
                    'description' => 'Proposals with Impact',
                    'param' => 'impactProposals',
                    'count' => null,
                ],
                [
                    'title' => 'First Timers',
                    'description' => 'Proposals from first time members!',
                    'param' => 'firstTimers',
                    'count' => null,
                ],
                [
                    'title' => 'One timers',
                    'description' => 'Members with only 1 proposal',
                    'param' => 'oneTimers',
                    'count' => null,
                ],
                [
                    'title' => 'Small Cap',
                    'description' => 'Proposals with budgets below 75K',
                    'param' => 'below75k',
                    'count' => null,
                ],
                [
                    'title' => 'Medium Cap',
                    'description' => 'Proposals with budgets between 75K & 250K',
                    'param' => 'mediumProposals',
                    'count' => null,
                ],
                [
                    'title' => 'Large Cap',
                    'description' => 'Proposals with budgets over 250K',
                    'param' => 'over250K',
                    'count' => null,
                ],
                [
                    'title' => 'Women Proposals',
                    'description' => 'Proposals By Women.',
                    'param' => 'womanProposals',
                    'count' => null,
                ],
            ]
        );
        $offset = (($this->currentFilterGroup ?? 1) - 1) * $this->filterGroupLimit;
        $slicedFilters = $filters->slice($offset);

        $pagination = new LengthAwarePaginator(
            $slicedFilters->take($this->filterGroupLimit),
            $filters->count(),
            $this->filterGroupLimit,
            $this->currentFilterGroup,
            [
                'pageName' => 'fg',
            ]
        );

        return $pagination->onEachSide(1)->toArray();
    }

    public function getProposalCount($param)
    {
        $option_ = $this->getUserFilters($param);

        $proposals = Proposal::search(
            null,
            function (Indexes $index, $query, $options) use ($option_) {
                if (isset($option_['filters']) && count($option_['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $option_['filters']);
                }

                return $index->search($query, $options);
            }
        )->raw();

        return $proposals['estimatedTotalHits'];
    }

    public function setCounts(Request $request): Collection
    {
        $params = $request->input();
        $counts = collect([]);

        foreach ($params as $param) {
            $count = $this->getProposalCount($param);
            $counts->put($param, $count);
        }

        return $counts;
    }

    public function setTaxonomy(Request $request)
    {
        $tax = $request->input('tax');
        $limit = $request->input(CatalystExplorerQueryParams::PER_PAGE, 24);
        if ($tax == 'Tag') {
            return
                Tag::whereRelation('proposals.fund.parent', 'id', $this->fund->id)
                    ->withCount(['proposals' => fn ($q) => $q->whereRelation('fund.parent', 'id', $this->fund->id)])
                    ->fastPaginate($limit, ['*'], 'p')->setPath('/')->onEachSide(1)->toArray();
        } else {
            return
                Category::whereRelation('proposals.fund.parent', 'id', $this->fund->id)
                    ->withCount(['proposals' => fn ($q) => $q->whereRelation('fund.parent', 'id', $this->fund->id)])
                    ->fastPaginate($limit, ['*'], 'p')->setPath('/')->onEachSide(1)->toArray();
        }
    }
}
