<?php

namespace App\Inertia\CatalystExplorer;

use App\Enums\CatalystExplorerQueryParams;
use App\Http\Controllers\Controller;
use App\Http\Resources\FundResource;
use App\Models\CatalystExplorer\Fund;
use App\Models\CatalystExplorer\Proposal;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Inertia\Inertia;
use Inertia\Response;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Scout\Builder;
use Meilisearch\Endpoints\Indexes;

class ChallengeController extends Controller
{
    protected int $currentPage = 1;

    public int $perPage = 24;

    protected Builder $searchBuilder;

    protected int $limit = 24;

    protected ?string $sortBy;

    protected ?string $sortOrder;

    public ?string $search = null;

    public Collection $peopleFilter;

    public function index(Request $request, Fund $fund): Response
    {
        $this->setSortFilters($request);

        $this->perPage = $request->input('l', 24);

        $this->currentPage = $request->input('p', 1);

        $this->peopleFilter = $request->collect(CatalystExplorerQueryParams::PEOPLE)->map(fn ($n) => intval($n));

        $props = [
            'fund' => new FundResource($fund),
            'sort' => "{$this->sortBy}:{$this->sortOrder}",
            'proposals' => $this->query($fund),
            'currPage' => $this->currentPage,
            'perPage' => $this->perPage,
            'fundedProposalsCount' => $this->fundedProposals($fund),
            'completedProposalsCount' => $this->completedProposals($fund),
            'totalAmountRequested' => $this->totalAmountRequested($fund),
            'totalAmountAwarded' => $this->totalAmountAwarded($fund),
            'filters' => [
                'people' => $this->peopleFilter->toArray(),
            ],
            'crumbs' => [
                ['link' => '/catalyst-explorer/funds', 'label' => 'Funds'],
                ['link' => $fund->parent->link, 'label' => $fund->parent->label, 'external' => true],
                ['label' => $fund->title],
            ],
        ];

        return Inertia::render('Challenge', $props);
    }

    private function fundedProposals($fund)
    {
        return Proposal::where('type', 'proposal')
            ->whereNotNull('funded_at')
            ->where('fund_id', $fund->id)
            ->count();
    }

    private function completedProposals($fund)
    {
        return Proposal::where([
            'status' => 'complete',
            'fund_id' => $fund->id,
        ])
            ->count();
    }

    private function totalAmountRequested($fund)
    {
        return Proposal::where('type', 'proposal')
            ->where('fund_id', $fund->id)
            ->sum('amount_requested');
    }

    private function totalAmountAwarded($fund)
    {
        return Proposal::where('type', 'proposal')
            ->whereNotNull('funded_at')
            ->where('fund_id', $fund->id)
            ->sum('amount_requested');
    }

    public function query($fund): array
    {
        $_options = [
            'filters' => array_merge([], $this->getUserFilters($fund)),
        ];
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
                if ((bool) $this->sortBy && (bool) $this->sortOrder) {
                    $options['sort'] = ["$this->sortBy:$this->sortOrder"];
                }
                $options['offset'] = (($this->currentPage ?? 1) - 1) * $this->perPage;
                $options['limit'] = $this->perPage;

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
    protected function getUserFilters($fund): array
    {
        $_options = [];
        if ($fund->id) {
            $_options[] = 'challenge.id = '.$fund->id;
        }
        if ($this->peopleFilter->isNotEmpty()) {
            $_options[] = 'users.id IN '.$this->peopleFilter->toJson();
        }

        return $_options;
    }

    protected function setSortFilters(Request $request)
    {
        $sort = collect(explode(':', $request->input(CatalystExplorerQueryParams::SORTS, '')))->filter();

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
    }
}
