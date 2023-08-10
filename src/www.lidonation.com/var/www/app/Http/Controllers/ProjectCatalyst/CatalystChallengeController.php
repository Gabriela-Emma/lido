<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Http\Resources\FundResource;
use App\Models\Fund;
use App\Models\Proposal;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Laravel\Scout\Builder;
use JetBrains\PhpStorm\ArrayShape;
use Meilisearch\Endpoints\Indexes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Fluent;
use Illuminate\Support\Collection;
use App\Enums\CatalystExplorerQueryParams;

class CatalystChallengeController extends Controller
{
    protected int $currentPage = 1;
    public int $perPage = 24;
    protected Builder $searchBuilder;
    public ?string $search = null;
    public Collection $peopleFilter;

    public function index(Request $request, $slug)
    {
        $this->perPage = $request->input('l', 24);

        $this->currentPage = $request->input('p', 1);

        $this->peopleFilter = $request->collect(CatalystExplorerQueryParams::PEOPLE)->map(fn ($n) => intval($n));


        $fund = Fund::where('slug', $slug)->first();

        $props = [
            'fund' => new FundResource($fund),
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
                ['label' => $fund->title]
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
            'fund_id' =>  $fund->id
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

    public function query($fund)
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
        if($fund->id){
            $_options[] = 'challenge.id = ' . $fund->id;
        }
        if ($this->peopleFilter->isNotEmpty()) {
            $_options[] = 'users.id IN '.$this->peopleFilter->toJson();
        }
        return $_options;
    }
}
