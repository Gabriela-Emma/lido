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
    protected null|string|Stringable $fundingStatus = null;
    protected null|string|Stringable $proposalCohort = null;
    protected null|string|Stringable $proposalType = null;

    protected ?string $sortBy = 'amount_requested';

    protected ?string $sortOrder = 'desc';

    protected int $limit = 24;

    protected ?bool $fundedProposalsFilter = false;

    protected Builder $searchBuilder;

    public Collection $fundsFilter;

    public Collection $challengesFilter;

    public Collection $tagsFilter;

    public Collection $peopleFilter;

    public Collection $budgets;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $sort = collect(explode(':', $request->input('st', '')));
        $this->sortBy = $sort->first();
        $this->sortOrder = $sort->last();

        $this->budgets = $request->collect('bs');
        $this->search = $request->input('s', null);
        $this->fundingStatus = match ($request->input('f', null)) {
            'o' => 'over_budget',
            'n' => 'not_approved',
            default => null
        };
        $this->proposalCohort = match ($request->input('co', null)) {
            'im' => 'impact_proposal',
            'wo' => 'woman_proposal',
            'id' => 'ideafest_proposal',
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

        // get filter(s) from request
        return Inertia::render('Proposals', [
            'search' => $this->search,
            'sort' => "{$this->sortBy}:{$this->sortOrder}",
            'filters' => [
                'funded' => $this->fundedProposalsFilter,
                'fundingStatus' => match ($this->fundingStatus) {
                    'over_budget' => 'o',
                    'not_approved' => 'n',
                    default => null
                },
                'cohort' => match ($this->proposalCohort) {
                    'impact_proposal' => 'im',
                    'woman_proposal' => 'wo',
                    'ideafest_proposal' => 'id',
                    default => null
                },
                'type' => match ($this->proposalType) {
                    'proposal' => 'p',
                    'challenge' => 'c',
                    default => null
                },
                'budgets' => $this->budgets->isNotEmpty() ? $this->budgets->toArray() : [1, 3000000],
                'funds' => $this->fundsFilter->toArray(),
                'challenges' => $this->challengesFilter->toArray(),
                'tags' => $this->tagsFilter->toArray(),
                'people' => $this->peopleFilter->toArray()
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


//        if ($this->completedProposalsFilter) {
//            $_options['filters'][] = 'completed = 1';
//        }

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
                    'challenge_label',
                    'ideascale_link',
                    'yes_votes_count',
                    'no_votes_count',
                    'problem',
                    'solution',
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
                if (!!$this->sortBy && !!$this->sortOrder) {
                    $options['sort'] = ["$this->sortBy:$this->sortOrder"];
                } else {
                    $options['sort'] = ['created_at:desc'];
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
    }

    #[ArrayShape(['filters' => 'array'])]
    protected function getUserFilters(): array
    {
        $_options = [];

        if (!!$this->fundingStatus) {
            $_options[] = "funding_status = {$this->fundingStatus}";
        }

        if (!!$this->proposalType) {
            $_options[] = "type = {$this->proposalType}";
        }

        if (!!$this->fundedProposalsFilter) {
            $_options[] = 'funded = 1';
        }

        if (!!$this->proposalCohort) {
            $_options[] = "{$this->proposalCohort} = true";
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

        // filter by budget range
        if ($this->budgets->isNotEmpty()) {
            $_options[] = "amount_requested >  {$this->budgets->first()} AND amount_requested <  {$this->budgets->last()}";
        }

        return $_options;
    }
}
