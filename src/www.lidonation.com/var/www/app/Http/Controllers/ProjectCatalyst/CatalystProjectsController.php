<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
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

    protected ?string $sortBy = 'amount_requested';

    protected ?string $sortOrder = 'desc';

    protected ?bool $fundedProposalsFilter = false;

    protected Builder $searchBuilder;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->search = $request->input('search', null);

//        dd($this->query($request));

        // get filter(s) from request
        return Inertia::render('Proposals', [
            'search' => $this->search,
            'proposals' => $this->query($request),
            'crumbs' => [
                [
                    'label' => 'Proposal'
                ],
            ],
        ]);
    }

    protected function query(Request $request)
    {
        $_options = [
            'filters' => array_merge([
            ], $this->getUserFilters()),
        ];


        // filter by funded bool
//        if ($this->fundedProposalsFilter) {
//            $_options['filters'][] = 'funded = 1';
//        }
//        if ($this->completedProposalsFilter) {
//            $_options['filters'][] = 'completed = 1';
//        }
//        if ($this->impactProposalsFilter) {
//            $_options['filters'][] = 'impact_proposal = true';
//        }
//        if ($this->proposalTypeFilter !== 'all') {
//            $_options['filters'][] = "type = $this->proposalTypeFilter";
//        }

        $this->searchBuilder = Proposal::search($this->search,
            function (Indexes $index, $query, $options) use ($_options) {
                if (count($_options['filters']) > 0) {
                    $options['filter'] = implode(' AND ', $_options['filters']);
                }
                $options['attributesToRetrieve'] = [
                    'id',
                    'slug',
                    'title',
                    'problem',
                    'solution',
                    'amount_requested',
                    'amount_received',
                ];
                if ($this->sortBy !== 'none' && $this->sortOrder !== 'none') {
                    $options['sort'] = ["$this->sortBy:$this->sortOrder"];
                } else {
                    if (!$this->search) {
                        $options['sort'] = ['created_at:desc'];
                    }
                }

                return $index->search($query, $options);
            });

        $response = new Fluent($this->searchBuilder->raw());
        $pagination = new LengthAwarePaginator(
            $response->hits,
            $response->estimatedTotalHits,
            $response->limit,
            null,
            [
                'pageName' => 'p'
            ]
        );

//        dd($pagination->toArray());
        return $pagination->toArray();


//        $this->paginator = $this->searchBuilder->paginate(
//            $this->perPage,
//        );
//        $this->proposals = $this->paginator->items();

        /////
        //////// get stats
        /////
//        $this->setTotalProposalsCountMetric();
//        $this->setAwardedAmount();
//        $this->setFundedProposalsCountMetric();
//        $this->setCompletedProposalsCountMetric();
//        $this->setChallengeMetrics();

//        $this->dispatchBrowserEvent('analytics-event-fired', ['code' => 'RPZTGJL8']);
        // over budget proposals
    }

    #[ArrayShape(['filters' => 'array'])]
    protected function getUserFilters(): array
    {
        $_options = [];

        // filter by fund
//        if ((bool) $this->fundFilter) {
//            $_filters = [];
//            foreach ($this->fundFilter as $fund) {
//                $_filters[] = "fund = {$fund}";
//            }
//            if (count($_filters) > 0) {
//                $_options[] = implode(' OR ', $_filters);
//            }
//        }
//
//        if ((bool) $this->challengeFilter) {
//            $_filters = [];
//            foreach ($this->challengeFilter as $challenge) {
//                $_filters[] = "challenge = {$challenge}";
//            }
//            if (count($_filters) > 0) {
//                $_options[] = implode(' OR ', $_filters);
//            }
//        }

        // filter by over budget bool
//        if ((bool) $this->overBudgetProposalsFilter) {
//            $_options[] = 'over_budget = 1';
//        }
//
        return $_options;
    }
}
