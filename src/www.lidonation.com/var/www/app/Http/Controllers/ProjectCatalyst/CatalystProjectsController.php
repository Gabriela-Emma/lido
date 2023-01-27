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

    protected int $limit = 24;

    protected ?bool $fundedProposalsFilter = false;

    protected Builder $searchBuilder;

    public Collection $fundsFilter;

    public Collection $challengesFilter;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->search = $request->input('search', null);
        $this->fundedProposalsFilter = $request->input('fp', false);
        $this->fundsFilter = $request->collect('fs')->map(fn($n) => intval($n));
        $this->challengesFilter = $request->collect('cs')->map(fn($n) => intval($n));

//        dd($this->challengesFilter);

        // get filter(s) from request
        return Inertia::render('Proposals', [
            'search' => $this->search,
            'filters' => [
                'funded' => $this->fundedProposalsFilter,
                'funds' => $this->fundsFilter->toArray(),
                'challenges' => $this->challengesFilter->toArray()
            ],
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
//                dd($options);
                $options['attributesToRetrieve'] = [
                    'id',
                    'slug',
                    'title',
                    'fund_label',
                    'fund_label',
                    'funding_status',
                    'challenge_label',
                    'problem',
                    'solution',
                    'users.name',
                    'users.media.original_url',
                    'users.profile_photo_url',
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

                $options['limit'] = $this->limit;

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

        if (!!$this->fundedProposalsFilter) {
            $_options[] = 'funded = 1';
        }

        // filter by fund
        if ($this->fundsFilter->isNotEmpty()) {
            $_options[] =  '(' . $this->fundsFilter->map(fn($f) => "fund = {$f}")->implode(' OR ') . ')';
        }

        // filter by challenge
        if ($this->challengesFilter->isNotEmpty()) {
            $_options[] =  '(' . $this->challengesFilter->map(fn($c) => "challenge = {$c}")->implode(' OR ') . ')';
        }


        // filter by over budget bool
//        if ((bool) $this->overBudgetProposalsFilter) {
//            $_options[] = 'over_budget = 1';
//        }
//
        return $_options;
    }
}
