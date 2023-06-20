<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Enums\CatalystExplorerQueryParams;
use App\Exports\ProposalExport;
use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Services\ExportModelService;
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
use Momentum\Modal\Modal;
use PhpOffice\PhpSpreadsheet\Exception;

class CatalystProjectsController extends Controller
{
    protected null|string|Stringable $search = null;

    protected null|string|Stringable $fundingStatus = null;

    protected null|string|Stringable $projectStatus = null;

    protected null|string|Stringable $proposalCohort = null;

    protected null|string|Stringable $proposalType = null;

    protected bool $download = false;

    protected ?string $downloadType = null;

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

    public function metricCountFunded(Request $request)
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

    public function metricCountCompleted(Request $request)
    {
        $this->setFilters($request);
        $this->projectStatus = 'complete';
        $this->limit = 1;
        $res = $this->query();
        if (isset($res['total'])) {
            return $res['total'];
        }

        return null;
    }

    public function metricCountTotalPaid(Request $request)
    {
        $this->setFilters($request);
        $this->fundingStatus = 'paid';
        $this->limit = 1;
        $res = $this->query();
        if (isset($res['total'])) {
            return $res['total'];
        }

        return null;
    }

    public function metricSumBudget(Request $request)
    {
        $this->setFilters($request);
        $this->limit = 10000;
        $res = $this->query(true, ['amount_requested'])->raw();

        if (isset($res['hits'])) {
            return collect($res['hits'])->sum('amount_requested');
        }

        return null;
    }

    public function metricSumApproved(Request $request)
    {
        $this->setFilters($request);
        $this->fundedProposalsFilter = true;
        $this->limit = 10000;
        $res = $this->query(true, ['amount_requested'])->raw();

        if (isset($res['hits'])) {
            return collect($res['hits'])->sum('amount_requested');
        }

        return null;
    }

    public function metricSumDistributed(Request $request)
    {
        $this->setFilters($request);
        $this->fundedProposalsFilter = true;
        $this->limit = 10000;
        $res = $this->query(true, ['amount_received'])->raw();

        if (isset($res['hits'])) {
            return collect($res['hits'])->sum('amount_received');
        }

        return null;
    }

    public function metricSumCompleted(Request $request)
    {
        $this->setFilters($request);
        $this->projectStatus = 'complete';
        $this->limit = 10000;
        $res = $this->query(true, ['amount_requested'])->raw();

        if (isset($res['hits'])) {
            return collect($res['hits'])->sum('amount_requested');
        }

        return null;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Modal
     */
    public function bookmark(Request $request, Proposal $proposal)
    {
        return Inertia::modal('BookmarkProposal')
            ->with([
                'proposal' => $proposal,
            ])
            ->baseRoute('catalystExplorer.proposals');
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
                'budgets' => $this->budgets->isNotEmpty() ? $this->budgets->toArray() : [CatalystExplorerQueryParams::MIN_BUDGET, CatalystExplorerQueryParams::MAX_BUDGET],
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
        $sort = collect(explode(':', $request->input(CatalystExplorerQueryParams::SORTS, '')));
        $this->sortBy = $sort->first();
        $this->sortOrder = $sort->last();

        $this->budgets = $request->collect(CatalystExplorerQueryParams::BUDGETS);
        $this->search = $request->input(CatalystExplorerQueryParams::SEARCH, null);
        $this->limit = $request->input(CatalystExplorerQueryParams::PER_PAGE, 24);
        $this->fundingStatus = match ($request->input('f', null)) {
            'o' => 'over_budget',
            'n' => 'not_approved',
            'f' => 'funded',
            'p' => 'paid',
            default => null
        };
        $this->projectStatus = match ($request->input(CatalystExplorerQueryParams::STATUS, null)) {
            'c' => 'complete',
            'i' => 'in_progress',
            'u' => 'unfunded',
            'p' => 'paused',
            default => null
        };
        $this->proposalCohort = match ($request->input(CatalystExplorerQueryParams::COHORT, null)) {
            'im' => 'impact_proposal',
            'wo' => 'woman_proposal',
            'id' => 'ideafest_proposal',
            'qp' => 'has_quick_pitch',
            default => null
        };
        $this->proposalType = match ($request->input(CatalystExplorerQueryParams::TYPE, CatalystExplorerQueryParams::PAGE)) {
            'p' => 'proposal',
            'c' => 'challenge',
            default => null
        };
        $this->fundedProposalsFilter = $request->input(CatalystExplorerQueryParams::FUNDED_PROPOSALS, false);
        $this->fundsFilter = $request->collect(CatalystExplorerQueryParams::FUNDS)->map(fn ($n) => intval($n));
        $this->challengesFilter = $request->collect(CatalystExplorerQueryParams::CHALLENGES)->map(fn ($n) => intval($n));
        $this->tagsFilter = $request->collect(CatalystExplorerQueryParams::TAGS)->map(fn ($n) => intval($n));
        $this->peopleFilter = $request->collect(CatalystExplorerQueryParams::PEOPLE)->map(fn ($n) => intval($n));
        $this->groupsFilter = $request->collect(CatalystExplorerQueryParams::GROUPS)->map(fn ($n) => intval($n));
        $this->currentPage = $request->input(CatalystExplorerQueryParams::PAGE, 1);
    }

    protected function query($returnBuilder = false, $attrs = null)
    {
        $_options = [
            'filters' => array_merge([
            ], $this->getUserFilters()),
        ];

        $this->searchBuilder = Proposal::search($this->search,
            function (Indexes $index, $query, $options) use ($_options, $attrs) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }

                $options['attributesToRetrieve'] = $attrs ?? [
                    'id',
                    'amount_requested',
                    'amount_received',
                    'currency',
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
                ];
                if ((bool) $this->sortBy && (bool) $this->sortOrder) {
                    $options['sort'] = ["$this->sortBy:$this->sortOrder"];
                } else {
                    $options['sort'] = ['amount_received:desc'];
                }

                $options['offset'] = (($this->currentPage ?? 1) - 1) * $this->limit;
                $options['limit'] = $this->limit;

                return $index->search($query, $options);
            });

        if ($returnBuilder) {
            return $this->searchBuilder;
        }
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

        if ((bool) $this->fundingStatus && $this->fundingStatus !== 'paid') {
            $_options[] = "funding_status = {$this->fundingStatus}";
        }

        if ((bool) $this->projectStatus) {
            $_options[] = "status = {$this->projectStatus}";
        }

        if ((bool) $this->proposalType) {
            $_options[] = "type = {$this->proposalType}";
        }

        if ((bool) $this->fundedProposalsFilter) {
            $_options[] = 'funded = 1';
        }

        if ((bool) $this->proposalCohort) {
            $_options[] = "{$this->proposalCohort} = 1";
        }

        // filter by fund
        if ($this->fundsFilter->isNotEmpty()) {
            $_options[] = '('.$this->fundsFilter->map(fn ($f) => "fund = {$f}")->implode(' OR ').')';
        }

        // filter by challenge
        if ($this->challengesFilter->isNotEmpty()) {
            $_options[] = '('.$this->challengesFilter->map(fn ($c) => "challenge = {$c}")->implode(' OR ').')';
        }

        // filter by tags
        if ($this->tagsFilter->isNotEmpty()) {
            $_options[] = 'tags.id IN '.$this->tagsFilter->toJson();
        }

        if ($this->peopleFilter->isNotEmpty()) {
            $_options[] = 'users.id IN '.$this->peopleFilter->toJson();
        }

        if ($this->groupsFilter->isNotEmpty()) {
            $_options[] = 'groups.id IN '.$this->groupsFilter->toJson();
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

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    protected function exportProposals(Request $request)
    {
        $this->setFilters($request);

        $this->download = $request->input('d', false);
        $this->downloadType = $request->input('d_t', null);

        $proposals = $this->query(true, ['id'])->paginate($this->limit, 'p', $this->currentPage)->toArray()['data'];
        $idsArr = array_map(function ($proposal) {
            return $proposal['id'];
        }, $proposals);

        if ($this->downloadType == 'excel') {
            return (new ExportModelService)->exportExcel(new ProposalExport($idsArr, app()->getLocale()), 'proposals');
        } else {
            return (new ExportModelService)->export(new ProposalExport($idsArr, app()->getLocale()), "proposals.{$this->downloadType}");
        }
    }
}
