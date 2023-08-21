<?php

namespace App\Http\Controllers\ProjectCatalyst;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Proposal;
use Illuminate\Support\Fluent;
use Illuminate\Http\Request;
use Meilisearch\Endpoints\Indexes;
use App\Http\Controllers\Controller;
use App\Repositories\FundRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use phpDocumentor\Reflection\PseudoTypes\ArrayShape;

class CatalystVoterToolController extends Controller
{
    public $fund;

    public $challenges;

    public $search;

    public $searchBuilder;

    protected int $currentPage;

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
        
        $this->search = $request->input('s', null);
        $this->perPage = $request->input('l', 24);
        $this->currentPage = $request->input('p', 1);
        $this->searchGroup = 'largeProposals';

        return Inertia::render('VoterTool1', [
            'search' => $this->search,
            'currentPage' =>  $this->currentPage,
            'perPage' => $this->perPage,
            'challenges' =>$this->challenges,
            'proposals' => $this->query(),
            'fund' => $this->fund,
            'crumbs' => [
                ['label' => 'Voter Tool'],
            ],
        ]);
    }

    protected function query()
    {
        $_options = $this->getUserFilters();

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
    function getUserFilters() 
    {
        if ($this->searchGroup == 'oneTimers' || $this->searchGroup == 'firstTimers') {
            $_options = [
                'filters' => [],
            ];
            if ($this->searchGroup == 'firstTimers') {
                $_options['filters'] = "first_timer = true AND proposals.fund = {$this->fund?->id}";
            }

            if ($this->searchGroup == 'oneTimers') {
                $_options['filters'][] = "proposals_count = 1 AND proposals.fund = {$this->fund?->id}";
            }
        }

        // $_options = [
        //     'filters' => ["fund.id = {$this->fund?->id}"],
        // ];

        if ($this->searchGroup == 'allStars') {
            $_options['filters'][] = 'ca_rating = 5';
        }

        if ($this->searchGroup == 'smallProposals') {
            $_options['filters'][] = 'amount_requested <= 10000';
        }

        if ($this->searchGroup == '100KProposals') {
            $_options['filters'][] = 'amount_requested >= 100000';
        }

        if ($this->searchGroup == 'largeProposals') {
            $_options['filters'][] = 'amount_requested > 25000';
        }

        if ($this->searchGroup == 'impactProposals') {
            $_options['filters'][] = 'impact_proposal = true';
        }

        if ($this->searchGroup == 'quickPitchProposals') {
            $_options['filters'][] = 'quickpitch IS NOT NULL';
        }

        if ($this->searchGroup == 'ideafestProposals') {
            $_options['filters'][] = 'ideafest_proposal = true';
        }

        if ($this->searchGroup == 'woman_proposal') {
            $_options['filters'][] = 'woman_proposal = 1';
        }
        return $_options;
    }


}
