<?php

namespace App\Http\View\Composers;

use App\Models\Proposal;
use App\Repositories\CatalystUserRepository;
use App\Repositories\FundRepository;
use Illuminate\Support\Fluent;
use Illuminate\View\View;

class CatalystUserComposer
{
    private $catalystUser;

    private $userProposals;

    private $allTimeCaAverage;

    private $allTimeCaRatingCount;

    private $allTimeCaAverageGroups;

    private Fluent $allTimeFundingPerRound;

    private Fluent $allTimeCompletedPerRound;

    private Fluent $allTimeFundedPerRound;

    private Fluent $allTimeAwardedPerRound;

    private Fluent $allTimeReceivedPerRound;

    private Fluent $allTimeProposedPerRound;

    /**
     * Create a new profile composer.
     */
    public function __construct(
        protected CatalystUserRepository $catalystUserRepository,
        protected FundRepository $fundRepository
    ) {
        $this->catalystUser = $this->catalystUserRepository->get(request()->route('catalystUser'));
        $this->userProposals = Proposal::whereHas('users', fn ($q) => $q->where('id', $this->catalystUser->id))
            ->paginate(
                $perPage = 18, $columns = ['*'], $pageName = 'proposals'
            );

        //        $this->userProposals = $this->catalystUser->proposals()->sortBy('proposals.fund.launched_at')->paginate(
        //            $perPage = 16, $columns = ['*'], $pageName = 'proposals'
        //        );

        // @todo This should be an injecktable operation
        $discussions = $this->catalystUser?->proposals
            ->map(
                fn ($p) => $p->discussions
            )->collapse();

        // combined ratings across all CA reviews
        $ratings = $discussions->map(fn ($disc) => $disc->ratings)->collapse();
        $this->allTimeCaRatingCount = $ratings->count();
        $this->allTimeCaAverage = $ratings->avg('rating');

        // combined ratings by discussion
        $groups = $ratings->map(fn ($v) => ([
            'rating' => $v->rating,
            'review' => $v->model->title,
        ]))->groupBy('review')
            ->map(
                fn ($v, $k) => [
                    'rating' => round($v->avg('rating'), 2),
                    'percent' => intval(round($v->avg('rating') / 5 * 100)),
                ]
            );
        $this->allTimeCaAverageGroups = $groups;

        $proposalGroups = $this->fundRepository->funds('funds')->map(
            fn ($fund) => new Fluent([
                'fund' => $fund,
                'proposals' => $this->catalystUser->proposals->filter(
                    fn ($p) => $p->fund->parent->id === $fund->id
                ),
            ])
        )->reverse();

        $labels = $proposalGroups->pluck('fund.title');
        $proposals = $proposalGroups->pluck('proposals');

        // ## Proposed
        $this->allTimeProposedPerRound = new Fluent([
            'labels' => $labels,
            'data' => $proposals->map(fn ($ps) => $ps->count()),
        ]);

        // ## Funded
        $this->allTimeFundedPerRound = new Fluent([
            'labels' => $labels,
            'data' => $proposals->map(
                fn ($ps) => $ps->countBy(fn ($p) => $p->funding_status)
            )->map(function ($g) {
                $complete = $g->get('complete') ?? 0;
                $funded = $g->get('funded') ?? 0;

                return $complete + $funded;
            })->values(),
        ]);

        // ## Completed
        $this->allTimeCompletedPerRound = new Fluent([
            'labels' => $labels,
            'data' => $proposals->map(
                fn ($ps) => $ps->countBy(fn ($p) => $p->status)
            )->map(fn ($g) => $g->get('complete') ?? 0)->values(),
        ]);

        // $$ Requested
        $this->allTimeFundingPerRound = new Fluent([
            'labels' => $labels,
            'data' => $proposals->map(
                fn ($ps) => $ps->sum('amount_requested')
            )->values(),
        ]);

        // $$ Awarded
        $this->allTimeAwardedPerRound = new Fluent([
            'labels' => $labels,
            'data' => $proposals->map(
                fn ($ps) => $ps->filter(fn ($p) => $p->funded)->sum('amount_requested')
            )->values(),
        ]);

        //  $$ Received
        $this->allTimeReceivedPerRound = new Fluent([
            'labels' => $labels,
            'data' => $proposals->map(
                fn ($ps) => $ps->sum('amount_received')
            )->values(),
        ]);
    }

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(
            [
                'metaTitle' => $this->catalystUser?->name,
                'catalystUser' => $this->catalystUser,
                'userProposals' => $this->userProposals,
                'allTimeCaAverage' => $this->allTimeCaAverage,
                'allTimeCaRatingCount' => $this->allTimeCaRatingCount,
                'allTimeCaAverageGroups' => $this->allTimeCaAverageGroups,

                'allTimeFundedPerRound' => $this->allTimeFundedPerRound,
                'allTimeFundingPerRound' => $this->allTimeFundingPerRound,
                'allTimeAwardedPerRound' => $this->allTimeAwardedPerRound,
                'allTimeReceivedPerRound' => $this->allTimeReceivedPerRound,
                'allTimeProposedPerRound' => $this->allTimeProposedPerRound,
                'allTimeCompletedPerRound' => $this->allTimeCompletedPerRound,
            ]
        );
    }
}
