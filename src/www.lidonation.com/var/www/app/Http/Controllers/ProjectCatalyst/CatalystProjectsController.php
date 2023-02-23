<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Illuminate\Support\Stringable;
use Inertia\Inertia;
use Inertia\Response;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Scout\Builder;
use Meilisearch\Endpoints\Indexes;

class CatalystProjectsController extends Controller
{
    protected null|string|Stringable $search = null;

    protected null|string|Stringable $fundingStatus = null;

    protected null|string|Stringable $projectStatus = null;

    protected null|string|Stringable $proposalCohort = null;

    protected null|string|Stringable $proposalType = null;

    protected ?string $sortBy = 'amount_requested';

    protected ?string $sortOrder = 'desc';

    protected int $currentPage;

    protected int $limit = 24;

    protected ?bool $fundedProposalsFilter = false;

    protected Builder $searchBuilder;

    public Collection $fundsFilter;

    public Collection $challengesFilter;

    public Collection $tagsFilter;

    public Collection $peopleFilter;

    public Collection $groupsFilter;

    public Collection $budgets;

    public function metricFunded(Request $request)
    {
        $this->setFilters($request);
        $this->fundedProposalsFilter = true;
        $this->limit = 1;
        $res = $this->query();
        if (isset($res['total'])) {
            return $res['total'];
        }
        return null;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->setFilters($request);

        // props
        $props = [
            'search' => $this->search,
            'perPage' => $this->limit,
            'sort' => "{$this->sortBy}:{$this->sortOrder}",
            'filters' => [
                'currentPage' => $this->currentPage,
                'funded' => $this->fundedProposalsFilter || $this->fundingStatus === 'funded',
                'fundingStatus' => match ($this->fundingStatus) {
                    'over_budget' => 'o',
                    'not_approved' => 'n',
                    'funded' => 'f',
                    'paid' => 'p',
                    default => null
                },
                'projectStatus' => match ($this->projectStatus) {
                    'complete' => 'c',
                    'in_progress' => 'i',
                    'unfunded' => 'u',
                    'paused' => 'p',
                    default => null
                },
                'cohort' => match ($this->proposalCohort) {
                    'impact_proposal' => 'im',
                    'woman_proposal' => 'wo',
                    'ideafest_proposal' => 'id',
                    'has_quick_pitch' => 'qp',
                    default => null
                },
                'type' => match ($this->proposalType) {
                    'proposal' => 'p',
                    'challenge' => 'c',
                    default => null
                },
                'budgets' => $this->budgets->isNotEmpty() ? $this->budgets->toArray() : [1, 2000000],
                'funds' => $this->fundsFilter->toArray(),
                'challenges' => $this->challengesFilter->toArray(),
                'tags' => $this->tagsFilter->toArray(),
                'people' => $this->peopleFilter->toArray(),
                'groups' => $this->groupsFilter->toArray(),
            ],
            'proposals' => $this->query(),
            'crumbs' => [
                [
                    'label' => 'Proposal',
                ],
            ],
        ];
        if ($this->currentPage > 1) {
            $props['currPage'] = $this->currentPage;
        }
        // get filter(s) from request
        return Inertia::render('Proposals', $props);
    }

    protected function setFilters(Request $request)
    {
        $sort = collect(explode(':', $request->input('st', '')));
        $this->sortBy = $sort->first();
        $this->sortOrder = $sort->last();

        $this->budgets = $request->collect('bs');
        $this->search = $request->input('s', null);
        $this->limit = $request->input('l', 24);
        $this->fundingStatus = match ($request->input('f', null)) {
            'o' => 'over_budget',
            'n' => 'not_approved',
            'f' => 'funded',
            'p' => 'paid',
            default => null
        };
        $this->projectStatus = match ($request->input('ss', null)) {
            'c' => 'complete',
            'i' => 'in_progress',
            'u' => 'unfunded',
            'p' => 'paused',
            default => null
        };
        $this->proposalCohort = match ($request->input('co', null)) {
            'im' => 'impact_proposal',
            'wo' => 'woman_proposal',
            'id' => 'ideafest_proposal',
            'qp' => 'has_quick_pitch',
            default => null
        };
        $this->proposalType = match ($request->input('t', 'p')) {
            'p' => 'proposal',
            'c' => 'challenge',
            default => null
        };
        $this->fundedProposalsFilter = $request->input('fp', false);
        $this->fundsFilter = $request->collect('fs')->map(fn($n) => intval($n));
        $this->challengesFilter = $request->collect('cs')->map(fn($n) => intval($n));
        $this->tagsFilter = $request->collect('ts')->map(fn($n) => intval($n));
        $this->peopleFilter = $request->collect('pp')->map(fn($n) => intval($n));
        $this->groupsFilter = $request->collect('g')->map(fn($n) => intval($n));
        $this->currentPage = $request->input('p', 1);
    }

    protected function query()
    {
        $_options = [
            'filters' => array_merge([
            ], $this->getUserFilters()),
        ];

        $this->searchBuilder = Proposal::search($this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }

                $options['attributesToRetrieve'] = [
                    'id',
                    'ca_rating',
                    'ratings_count',
                    'slug',
                    'title',
                    'fund_label',
                    'fund_label',
                    'funding_status',
                    'groups.id',
                    'challenge_label',
                    'ideascale_link',
                    'yes_votes_count',
                    'no_votes_count',
                    'paid',
                    'problem',
                    'solution',
                    'status',
                    'website',
                    'type',
                    'users.id',
                    'users.name',
                    'users.username',
                    'users.media.original_url',
                    'users.profile_photo_url',
                    'amount_requested',
                    'amount_received',
                ];
                if ((bool)$this->sortBy && (bool)$this->sortOrder) {
                    $options['sort'] = ["$this->sortBy:$this->sortOrder"];
                } else {
                    $options['sort'] = ['amount_received:desc'];
                }

                $options['offset'] = (($this->currentPage ?? 1) - 1) * $this->limit;
                $options['limit'] = $this->limit;

                return $index->search($query, $options);
            });

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
    protected function getUserFilters(): array
    {
        $_options = [];

        if ((bool)$this->fundingStatus && $this->fundingStatus !== 'paid') {
            $_options[] = "funding_status = {$this->fundingStatus}";
        }

        if ((bool)$this->projectStatus) {
            $_options[] = "status = {$this->projectStatus}";
        }

        if ((bool)$this->proposalType) {
            $_options[] = "type = {$this->proposalType}";
        }

        if ((bool)$this->fundedProposalsFilter) {
            $_options[] = 'funded = 1';
        }

        if ((bool)$this->proposalCohort) {
            $_options[] = "{$this->proposalCohort} = 1";
        }

        // filter by fund
        if ($this->fundsFilter->isNotEmpty()) {
            $_options[] = '(' . $this->fundsFilter->map(fn($f) => "fund = {$f}")->implode(' OR ') . ')';
        }

        // filter by challenge
        if ($this->challengesFilter->isNotEmpty()) {
            $_options[] = '(' . $this->challengesFilter->map(fn($c) => "challenge = {$c}")->implode(' OR ') . ')';
        }

        // filter by tags
        if ($this->tagsFilter->isNotEmpty()) {
            $_options[] = 'tags.id IN ' . $this->tagsFilter->toJson();
        }

        if ($this->peopleFilter->isNotEmpty()) {
            $_options[] = 'users.id IN ' . $this->peopleFilter->toJson();
        }

        if ($this->groupsFilter->isNotEmpty()) {
            $_options[] = 'groups.id IN ' . $this->groupsFilter->toJson();
        }

        // filter by budget range
        if ($this->budgets->isNotEmpty()) {
            $_options[] = "(amount_requested  {$this->budgets->first()} TO  {$this->budgets->last()})";
        }

        if ($this->fundingStatus === 'paid') {
            $_options[] = '(paid = 1)';
        }

        return $_options;
    }
}
