<?php

namespace App\Inertia\CatalystExplorer;

use App\Enums\CatalystExplorerQueryParams;
use App\Http\Controllers\Controller;
use App\Models\CatalystExplorer\CatalystUser;
use App\Models\CatalystExplorer\Fund;
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

class PeopleController extends Controller
{
    protected null|string|Stringable $search = null;

    protected int $currentPage;

    public ?string $sort = null;

    protected ?string $sortBy = 'name';

    protected ?string $sortOrder = 'desc';

    protected int $limit = 24;

    protected ?bool $fundedProposalsFilter = false;

    protected Builder $searchBuilder;

    public Collection $fundsFilter;

    public Collection $tagsFilter;

    public Collection $budgets;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->setFilters($request);

        $funds = Fund::funds()
            ->get()
            ->map(fn ($f) => new Fluent(['id' => $f->id, 'title' => $f->title]));

        // props
        $props = [
            'search' => $this->search,
            'funds' => $funds,
            'sort' => "{$this->sortBy}:{$this->sortOrder}",
            'currPage' => $this->currentPage,
            'perPage' => $this->limit,
            'filters' => [
                'currentPage' => $this->currentPage,
                'perPage' => $this->limit,
                'funded' => $this->fundedProposalsFilter,
                'budgets' => $this->budgets->isNotEmpty() ? $this->budgets->toArray() : [CatalystExplorerQueryParams::MIN_BUDGET, CatalystExplorerQueryParams::MAX_BUDGET],
                'funds' => $this->fundsFilter->toArray(),
                'tags' => $this->tagsFilter->toArray(),
            ],
            'users' => $this->query(),
            'crumbs' => [
                [
                    'label' => 'Funds',
                    'link' => route('catalyst-explorer.funds.index'),
                ],
                ['label' => 'Proposals', 'link' => route('catalyst-explorer.proposals')],
                ['label' => 'People'],
            ],
        ];

        return Inertia::render('People', $props);
    }

    protected function setFilters(Request $request)
    {
         
        $this->limit = $request->input(CatalystExplorerQueryParams::PER_PAGE, 24);

        $sort = collect(explode(':', $request->input(CatalystExplorerQueryParams::SORTS, '')))->filter();
        if ($sort->isEmpty()) {
            $sort = collect(explode(':', collect([
                'name:asc',
                'name:desc',
                'amount_awarded_ada:asc',
                'amount_awarded_ada:desc',
                'amount_awarded_usd:asc',
                'amount_awarded_usd:desc',
                'own_proposals_count:asc',
                'own_proposals_count:desc',
                'co_proposals:asc',
                'co_proposals:desc'
            ])->random()));
        }

        $this->sortBy = $sort->first();
        $this->sortOrder = $sort->last();

        $this->budgets = $request->collect(CatalystExplorerQueryParams::BUDGETS);
        $this->search = $request->input(CatalystExplorerQueryParams::SEARCH, null);
        $this->currentPage = $request->input(CatalystExplorerQueryParams::PAGE, 1);

        $this->fundedProposalsFilter = $request->input(CatalystExplorerQueryParams::FUNDED_PROPOSALS, false);
        $this->fundsFilter = $request->collect(CatalystExplorerQueryParams::FUNDS)->map(fn ($n) => intval($n));
        $this->tagsFilter = $request->collect(CatalystExplorerQueryParams::TAGS)->map(fn ($n) => intval($n));
    }

    public function query($returnBuilder = false, $attrs = null, $filters = [])
    {
        $_options = [
            'filters' => array_merge([], $this->getUserFilters(), $filters),
        ];

        $this->searchBuilder = CatalystUser::search(
            $this->search,
            function (Indexes $index, $query, $options) use ($_options, $attrs) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }
                $options['attributesToRetrieve'] = $attrs ?? [
                    'id',
                    'name',
                    'own_proposals_count',
                    'co-proposals',
                    'username',
                    'first_timer',
                    'proposals_count',
                    'proposals_completed',
                    'profile_photo_url',
                    'media.original_url',
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

        if ((bool) $this->fundedProposalsFilter) {
            $_options[] = 'proposals_approved > 0';
        }

        if ($this->budgets->isNotEmpty()) {
            $_options[] = "(proposals_total_amount_requested {$this->budgets->first()} TO  {$this->budgets->last()})";
        }

        // filter by fund
        if ($this->fundsFilter->isNotEmpty()) {
            $_options[] = 'proposals.fund.parent_id IN '.$this->fundsFilter->toJson();
        }

        //  filter by tags
        if ($this->tagsFilter->isNotEmpty()) {
            $_options[] = 'proposals.tags.id IN '.$this->tagsFilter->toJson();
        }

        return $_options;
    }

    public function getFilteredData(Request $request)
    {
        $this->setFilters($request);

        return $this->query();
    }
}
