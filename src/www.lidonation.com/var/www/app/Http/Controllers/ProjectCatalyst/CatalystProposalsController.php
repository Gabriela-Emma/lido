<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Enums\CatalystExplorerQueryParams;
use App\Exports\ProposalExport;
use App\Http\Controllers\Controller;
use App\Models\DraftBallot;
use App\Models\Proposal;
use App\Services\ExportModelService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Illuminate\Support\Stringable;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Scout\Builder;
use Meilisearch\Endpoints\Indexes;
use Momentum\Modal\Modal;
use PhpOffice\PhpSpreadsheet\Exception;

class CatalystProposalsController extends Controller
{
    protected null|string|Stringable $search = null;

    protected null|string|Stringable $ranked = null;

    protected null|string|Stringable $quickpitches = null;

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

    protected ?bool $opensourceProposalsFilter = false;

    protected Builder $searchBuilder;

    public Collection $fundsFilter;

    public Collection $challengesFilter;

    public Collection $tagsFilter;

    public Collection $categoriesFilter;

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
        $currency = $request->get('currency', 'USD');
        $this->limit = 10000;
        $res = $this->query(true, ['amount_requested'], ["currency = {$currency}"])->raw();

        if (isset($res['hits'])) {
            return collect($res['hits'])->sum('amount_requested');
        }

        return null;
    }

    public function metricSumApproved(Request $request)
    {
        $currency = $request->get('currency', 'USD');
        $this->setFilters($request);
        $this->fundedProposalsFilter = true;
        $this->limit = 10000;
        $res = $this->query(true, ['amount_requested'], ["currency = {$currency}"])->raw();

        if (isset($res['hits'])) {
            return collect($res['hits'])->sum('amount_requested');
        }

        return null;
    }

    public function metricSumDistributed(Request $request)
    {
        $currency = $request->get('currency', 'USD');
        $this->setFilters($request);
        $this->fundedProposalsFilter = true;
        $this->limit = 10000;
        $res = $this->query(true, ['amount_received'], ["currency = {$currency}"])->raw();

        if (isset($res['hits'])) {
            return collect($res['hits'])->sum('amount_received');
        }

        return null;
    }

    public function metricSumCompleted(Request $request)
    {
        $currency = $request->get('currency', 'USD');
        $this->setFilters($request);
        $this->projectStatus = 'complete';
        $this->limit = 10000;
        $res = $this->query(true, ['amount_requested'], ["currency = {$currency}"])->raw();

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
                'opensource' => $this->opensourceProposalsFilter,
                'fundingStatus' => match ($this->fundingStatus) {
                    'over_budget' => CatalystExplorerQueryParams::OVER_BUDGET,
                    'not_approved' => CatalystExplorerQueryParams::NOT_APPROVED,
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
                    'has_quick_pitch' => CatalystExplorerQueryParams::QUICKPITCHES,
                    default => null
                },
                'type' => match ($this->proposalType) {
                    'proposal' => 'p',
                    'challenge' => 'c',
                    null => 'b',
                    default => null
                },
                'budgets' => $this->budgets->isNotEmpty() ? $this->budgets->toArray() : [CatalystExplorerQueryParams::MIN_BUDGET, CatalystExplorerQueryParams::MAX_BUDGET],
                'funds' => $this->fundsFilter->toArray(),
                'challenges' => $this->challengesFilter->toArray(),
                'tags' => $this->tagsFilter->toArray(),
                'categories' => $this->categoriesFilter->toArray(),
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

        return Inertia::render('Proposals', $props);
    }

    protected function setFilters(Request $request)
    {
        $this->limit = $request->input(CatalystExplorerQueryParams::PER_PAGE, 24);
        $this->ranked = $request->has(CatalystExplorerQueryParams::RANKED_VIEW);
        if (
            $this->ranked &&
            !Str::of($request->input(CatalystExplorerQueryParams::SORTS))
                ->contains('ranking_total')
        ) {
            $sort = collect(['ranking_total', 'desc']);
            if ($this->limit == 24) {
                $this->limit = 36;
            }
        } else {
            $sort = collect(
                explode(
                    ':',
                    $request->input(CatalystExplorerQueryParams::SORTS, '')
                )
            )->filter();
        }
        if ($sort->isEmpty()) {
            $sort = collect(explode(':', collect([
                'amount_requested:asc',
                'amount_received:asc',
                'amount_requested:desc',
                'amount_received:desc',
                'ca_rating:asc',
                'created_at:asc',
                'ca_rating:desc',
                'created_at:desc',
                'funded_at:asc',
                'funded_at:desc',
                'no_votes_count:desc',
                'no_votes_count:asc',
                'project_length:asc',
                'project_length:desc',
                'quickpitch_length:asc',
                'quickpitch_length:desc',
                'ranking_total:desc',
                'ranking_total:asc',
                'yes_votes_count:asc',
                'yes_votes_count:desc',
            ])->random()));
        }
        $this->sortBy = $sort->first();
        $this->sortOrder = $sort->last();
        $this->budgets = $request->collect(CatalystExplorerQueryParams::BUDGETS);
        $this->search = $request->input(CatalystExplorerQueryParams::SEARCH, null);
        $this->quickpitches = $request->has(CatalystExplorerQueryParams::QUICKPITCHES);

        $this->fundingStatus = match ($request->input('f', null)) {
            CatalystExplorerQueryParams::OVER_BUDGET => 'over_budget',
            CatalystExplorerQueryParams::NOT_APPROVED => 'not_approved',
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
            CatalystExplorerQueryParams::QUICKPITCHES => 'has_quick_pitch',
            default => null
        };
        $this->proposalType = match ($request->input(CatalystExplorerQueryParams::TYPE, CatalystExplorerQueryParams::PAGE)) {
            'p' => 'proposal',
            'c' => 'challenge',
            'b' => null,
            default => null
        };
        $this->fundedProposalsFilter = $request->input(CatalystExplorerQueryParams::FUNDED_PROPOSALS, false);
        $this->opensourceProposalsFilter = $request->input(CatalystExplorerQueryParams::OPENSOURCE_PROPOSALS, false);
        $this->fundsFilter = $request->collect(CatalystExplorerQueryParams::FUNDS)->map(fn ($n) => intval($n));
        $this->challengesFilter = $request->collect(CatalystExplorerQueryParams::CHALLENGES)->map(fn ($n) => intval($n));
        $this->tagsFilter = $request->collect(CatalystExplorerQueryParams::TAGS)->map(fn ($n) => intval($n));
        $this->categoriesFilter = $request->collect(CatalystExplorerQueryParams::CATEGORIES)->map(fn ($n) => intval($n));
        $this->peopleFilter = $request->collect(CatalystExplorerQueryParams::PEOPLE)->map(fn ($n) => intval($n));
        $this->groupsFilter = $request->collect(CatalystExplorerQueryParams::GROUPS)->map(fn ($n) => intval($n));
        $this->currentPage = $request->input(CatalystExplorerQueryParams::PAGE, 1);
    }

    protected function query($returnBuilder = false, $attrs = null, $filters = [])
    {
        $_options = [
            'filters' => array_merge([], $this->getUserFilters(), $filters),
        ];

        $this->searchBuilder = Proposal::search(
            $this->search,
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
                    'aligment_score',
                    'feasibility_score',
                    'auditability_score',
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
                if ((bool) $this->sortBy && (bool) $this->sortOrder) {
                    $options['sort'] = ["$this->sortBy:$this->sortOrder"];
                }

                $options['offset'] = (($this->currentPage ?? 1) - 1) * $this->limit;
                $options['limit'] = $this->limit;

                return $index->search($query, $options);
            }
        );

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

        if ((bool) $this->opensourceProposalsFilter) {
            $_options[] = 'opensource = 1';
        }

        if ((bool) $this->proposalCohort) {
            $_options[] = "{$this->proposalCohort} = 1";
        }

        if ((bool) $this->quickpitches) {
            $_options[] = "quickpitch IS NOT NULL";
        }

        // filter by fund
        if ($this->fundsFilter->isNotEmpty()) {
            $_options[] = '(' . $this->fundsFilter->map(fn ($f) => "fund.id = {$f}")->implode(' OR ') . ')';
        }

        // filter by challenge
        if ($this->challengesFilter->isNotEmpty()) {
            $_options[] = '(' . $this->challengesFilter->map(fn ($c) => "challenge.id = {$c}")->implode(' OR ') . ')';
        }

        // filter by tags
        if ($this->tagsFilter->isNotEmpty()) {
            $_options[] = 'tags.id IN ' . $this->tagsFilter->toJson();
        }

        if ($this->categoriesFilter->isNotEmpty()) {
            $_options[] = 'categories.id IN ' . $this->categoriesFilter->toJson();
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

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    protected function exportProposals(Request $request)
    {
        $this->setFilters($request);

        $this->download = $request->input('d', false);
        $this->downloadType = $request->input('d_t', null);

        $proposals = $this->query(true, ['id'])->fastPaginate($this->limit, 'p', $this->currentPage)->toArray()['data'];
        $idsArr = array_map(function ($proposal) {
            return $proposal['id'];
        }, $proposals);

        if ($this->downloadType == 'excel') {
            return (new ExportModelService)->exportExcel(new ProposalExport($idsArr, app()->getLocale()), 'proposals');
        } else {
            return (new ExportModelService)->export(new ProposalExport($idsArr, app()->getLocale()), "proposals.{$this->downloadType}");
        }
    }

    protected function downloadProposals(Request $request)
    {
        $this->download = $request->input('d', false);
        $this->downloadType = $request->input('d_t', null);
        if (!isset($request->ballot)){
            return;
        }

        $ballot = DraftBallot::byHash($request->ballot);

        if (!$ballot instanceof DraftBallot) {
            return;
        }
        $proposalIds = $ballot->proposals()->get(['model_id'])
        ->pluck('model_id')->values();

        return (new ExportModelService)
        ->export(
            new ProposalExport(
                $proposalIds,
                app()->getLocale()),
                "proposals.{$this->downloadType}"
        );
    }
}
