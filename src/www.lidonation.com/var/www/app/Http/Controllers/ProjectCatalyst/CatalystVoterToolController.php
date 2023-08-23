<?php

namespace App\Http\Controllers\ProjectCatalyst;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use Meilisearch\Endpoints\Indexes;
use App\Http\Controllers\Controller;
use App\Repositories\FundRepository;
use App\Enums\CatalystExplorerQueryParams;
use Illuminate\Pagination\LengthAwarePaginator;
use phpDocumentor\Reflection\PseudoTypes\ArrayShape;
use PhpOffice\PhpSpreadsheet\Calculation\LookupRef\Offset;

class CatalystVoterToolController extends Controller
{
    public $fund;

    public $challenges;

    public $search;

    public $searchBuilder;

    protected $currentPage;

    protected  $currentFilterGroup;

    protected $filterGroupLimit;

    protected int $limit = 24;

    public  $searchGroup = null;

    public $perPage;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function __construct()
    {
        $this->fund = app(FundRepository::class)->funds('inGovernance')->first();
        $this->challenges = app(FundRepository::class)->fundChallenges($this->fund);
    }


    public function index(Request $request)
    {
        $this->search = $request->input(CatalystExplorerQueryParams::SEARCH, null);
        $this->limit = $request->input(CatalystExplorerQueryParams::PER_PAGE, 24);
        $this->currentPage = $request->input('p', 1);
        $this->searchGroup = $request->input('fg', null);
        $this->currentFilterGroup = $request->input('fgs', 1);
        $this->filterGroupLimit = $request->input('pfgs', 6);

        return Inertia::render('VoterTool1', [
            'search' => $this->search,
            'currentPage' =>  $this->currentPage,
            'perPage' => $this->limit,
            'challenges' => $this->challenges,
            'proposals' => $this->query(),
            'fund' => $this->fund,
            'crumbs' => [
                ['label' => 'Voter Tool'],
            ],
            'filters' => $this->getGroupFilters(),
            'filterPerPage' => intval($this->filterGroupLimit),
            'currentFilter' => $this->searchGroup,
        ]);
    }

    protected function query()
    {
        if (!$this->search && !$this->searchGroup) {
            return null;
        }
        $_options = $this->getUserFilters($this->searchGroup);

        $this->searchBuilder = Proposal::search(
            $this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }

                $options['attributesToRetrieve'] =  [
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

        return $pagination->onEachSide(1)->toArray();
    }

    #[ArrayShape(['filters' => 'array'])]
    function getUserFilters($param)
    {
        $_options = [
            'filters' => [],
        ];

        $_options = [
            'filters' => ["fund.id = {$this->fund?->id}"],
        ];

        if ($param == 'firstTimers' ) {
            $_options['filters'][] = "first_timer = true AND proposals.fund = {$this->fund?->id}";
        }

        if ($param== 'oneTimers') {
            $_options['filters'][] = "proposals_count = 1 AND proposals.fund = {$this->fund?->id}";
        }

        if ( $param == 'allStars') {
            $_options['filters'][] = 'ca_rating = 5';
        }

        if ( $param == 'smallProposals') {
            $_options['filters'][] = 'amount_requested <= 75000';
        }

        if ($param == 'LargeProposals') {
            $_options['filters'][] = 'amount_requested >= 250000';
        }

        if ($param == 'mediumProposals') {
            $_options['filters'][] = 'amount_requested >= 75000 AND amount_requested <= 250000 ';
        }

        if ($param == 'impactProposals') {
            $_options['filters'][] = 'impact_proposal = true';
        }

        if ($param == 'quickPitchProposals') {
            $_options['filters'][] = 'quickpitch IS NOT NULL';
        }

        if ($param == 'ideafestProposals') {
            $_options['filters'][] = 'ideafest_proposal = true';
        }

        if ($param == 'womanProposals') {
            $_options['filters'][] = 'woman_proposal = 1';
        }

        if ( $param == 'opensource') {
            $_options['filters'][] = 'opensource = 1';
        }
        return $_options;
    }

    public function getGroupFilters()
    {
        $this->getProposalCount('smallProposals');

        $filters =   collect([
            [
                "title" => "Quick Pitches",
                "description" => "Proposals with Quick Pitches.",
                "param" => "quickPitchProposals",
                "count" => $this->getProposalCount('quickPitchProposals')
            ],
            [
                "title" => "Ideafest Proposals",
                "description" => "Projects presented at Ideafest!",
                "param" => "ideafestProposals",
                "count" => $this->getProposalCount('ideafestProposals')
            ],
            [
                "title" =>  "Women Proposals",
                "description" =>  "Proposals By Women.",
                "param" =>  "womanProposals",
                "count" => $this->getProposalCount('womanProposals')
            ],
            [
                "title" =>  "First Timers",
                "description" =>  "Proposals from first time members!",
                "param" =>  "firstTimers",
                "count" => $this->getProposalCount('firstTimers')
            ],
            [
                "title" =>  "Opensource",
                "description" =>  "Opensource projects",
                "param" =>  "opensource",
                "count" => $this->getProposalCount('opensource')
            ],
            [
                "title" =>  "One timers",
                "description" =>  "Members with only 1 proposal",
                "param" =>  "oneTimers",
                "count" => $this->getProposalCount('oneTimers')
            ],
            [
                "title" =>  "Small Cap",
                "description" =>  "Proposals with budgets below 75K",
                "param" =>  "smallProposals",
                "count" => $this->getProposalCount('smallProposals')
            ],
            [
                "title" =>  "Medium Cap",
                "description" =>  "Proposals with budgets between 75K & 250K",
                "param" =>  "mediumProposals",
                "count" => $this->getProposalCount('mediumProposals')
            ],
            [
                "title" =>  "Large Cap",
                "description" =>  "Proposals with budgets over 250K",
                "param" =>  "250KProposals",
                "count" => $this->getProposalCount('250KProposals')
            ],

        ]);
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
            '',
            function (Indexes $index, $query, $options) use ($option_) {
                if (count($option_['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $option_['filters']);
                }
                return $index->search($query, $options);
            }
        )->raw();
        return $proposals['estimatedTotalHits'];
    }
}
