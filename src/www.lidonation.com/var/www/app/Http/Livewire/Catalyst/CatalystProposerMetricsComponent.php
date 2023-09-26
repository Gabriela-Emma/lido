<?php

namespace App\Http\Livewire\Catalyst;

use Livewire\Component;
use App\Models\CatalystUser;
use Illuminate\Support\Fluent;
use Illuminate\Contracts\View\View;
use App\Repositories\FundRepository;
use Illuminate\Contracts\View\Factory;
use App\Repositories\CatalystUserRepository;
use Illuminate\Contracts\Foundation\Application;

class CatalystProposerMetricsComponent extends Component
{
    public bool $ownMetrics = true;

    public CatalystUser $catalystUser;

    protected $allTimeCaAverage;

    protected $allTimeCaRatingCount;

    protected $allTimeCaAverageGroups;

    protected $allTimeFundedPerRound;

    protected $allTimeAwardedPerRound;

    protected $allTimeReceivedPerRound;

    protected $allTimeFundingPerRound;

    protected $allTimeProposedPerRound;

    protected $allTimeCompletedPerRound;

    protected $allDiscussions;

    public $discussionData;

    public function toggleOwnMetrics(CatalystUserRepository $catalystUserRepository, FundRepository $fundRepository, CatalystUser $catalystUser)
    {
        $this->ownMetrics = !$this->ownMetrics;
        $this->setData($catalystUserRepository, $fundRepository, $catalystUser);
        $this->emit('ownMetricsToggle');
    }

    public function getMetric($metric)
    {
        return $this->{$metric};
    }

    public function getMetricData(string $metric, CatalystUser $catalystUser, CatalystUserRepository $catalystUserRepository, FundRepository $fundRepository)
    {
        $this->setData($catalystUserRepository, $fundRepository, $catalystUser);

        return $this->{$metric}?->data?->toArray() ?? [];
    }

    public function mount(
        CatalystUserRepository $catalystUserRepository,
        FundRepository $fundRepository,
        CatalystUser $catalystUser
    ) {
        $this->setData($catalystUserRepository, $fundRepository, $catalystUser);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.catalyst.proposer.metrics');
    }

    protected function setData(CatalystUserRepository $catalystUserRepository, FundRepository $fundRepository, CatalystUser $catalystUser)
    {
        $relation = $this->ownMetrics ? 'own_proposals' : 'proposals';
        if ($catalystUser?->username) {
            $username = $catalystUser->username;
        } else {
            $username = request()->route('catalystUser');
        }
        $this->catalystUser = $catalystUserRepository->get($username, 'own_proposals');
        //
        $discussions = $this->catalystUser?->{$relation}
            ->map(
                fn ($p) => $p->discussions
            )->collapse();
        $this->allDiscussions = $discussions;
        $this->discussionsRatings();
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
        $proposalGroups = $fundRepository->funds('funds')->map(
            fn ($fund) => new Fluent([
                'fund' => $fund,
                'proposals' => $this->catalystUser->{$relation}->filter(
                    fn ($p) => $p->fund->parent->id === $fund->id
                ),
            ])
        )->reverse();

        $labels = $proposalGroups->pluck('fund.title');
        $currency = $proposalGroups->pluck('fund.currency');
        $allProposals = $proposalGroups->pluck('proposals');

        $usdProposal = $proposalGroups->map(function ($item) {
            if ($item->fund->currency == 'USD') {
                return $item;
            }
        })?->pluck('proposals');

        $adaProposal = $proposalGroups->map(function ($item) {
            if ($item->fund->currency == 'ADA') {
                return $item;
            }
        })?->pluck('proposals');

        $this->setAllTimeProposedPerRound($labels, $allProposals);
        $this->setAllTimeCompletedPerRound($labels, $allProposals);
        $this->setAllTimeFundingPerRound($labels, $allProposals, $currency, $adaProposal, $usdProposal);
        $this->setAllTimeReceivedPerRound($labels, $allProposals, $currency, $adaProposal, $usdProposal);
        $this->setAllTimeAwardedPerRound($labels, $allProposals, $currency, $adaProposal, $usdProposal);
        $this->setAllTimeFundedPerRound($labels, $allProposals);
    }

    // ## Proposed
    protected function setAllTimeProposedPerRound($labels, $proposals)
    {
        $this->allTimeProposedPerRound = new Fluent([
            'labels' => $labels,
            'data' => $proposals->map(fn ($ps) => $ps->count()),
        ]);
    }

    // ## Funded
    protected function setAllTimeFundedPerRound($labels, $proposals)
    {
        $this->allTimeFundedPerRound = new Fluent([
            'labels' => $labels,
            'data' => $proposals->map(
                fn ($ps) => $ps->countBy(fn ($p) => $p->funding_status)
            )->map(fn ($g) => $g->get('funded') ?? 0)->values(),
        ]);
    }

    //  $$ Received
    protected function setAllTimeReceivedPerRound($labels, $proposals, $currency, $adaProposal, $usdProposal)
    {
        $this->allTimeReceivedPerRound = new Fluent([
            'labels' => $labels,
            'currency' => $currency,
            'totalAda' => $adaProposal->flatMap(function ($proposalCollection) {
                return $proposalCollection?->pluck('amount_received');
            })->sum(),
            'totalUsd' => $usdProposal->flatMap(function ($proposalCollection) {
                return $proposalCollection?->pluck('amount_received');
            })->sum(),
            'data' => $proposals->map(
                fn ($ps) => $ps->sum('amount_received')
            )->values(),
        ]);
    }

    // $$ Awarded
    protected function setAllTimeAwardedPerRound($labels, $proposals, $currency, $adaProposal, $usdProposal)
    {
        $this->allTimeAwardedPerRound = new Fluent([
            'labels' => $labels,
            'currency' => $currency,
            'totalAda' => $adaProposal->flatMap(function ($proposalCollection) {
                return $proposalCollection?->filter(function ($proposal) {
                    return $proposal['funded'];
                })->pluck('amount_received');
            })->sum(),
            'totalUsd' => $usdProposal->flatMap(function ($proposalCollection) {
                return $proposalCollection?->filter(function ($proposal) {
                    return $proposal['funded']; 
                })->pluck('amount_received');
            })->sum(),
            'data' => $proposals->map(
                fn ($ps) => $ps->filter(fn ($p) => $p->funded)->sum('amount_requested')
            )->values(),
        ]);

    }

    // $$ Requested
    protected function setAllTimeFundingPerRound($labels, $proposals, $currency, $adaProposal, $usdProposal)
    {
        $this->allTimeFundingPerRound = new Fluent([
            'labels' => $labels,
            'currency' => $currency,
            'totalAda' => $adaProposal->flatMap(function ($proposalCollection) {
                return $proposalCollection?->pluck('amount_received');
            })->sum(),
            'totalUsd' => $usdProposal->flatMap(function ($proposalCollection) {
                return $proposalCollection?->pluck('amount_requested');
            })->sum(),
            'data' => $proposals->map(
                fn ($ps) => $ps->sum('amount_requested')
            )->values(),
        ]);

    }

    // ## Completed
    protected function setAllTimeCompletedPerRound($labels, $proposals)
    {
        $this->allTimeCompletedPerRound = new Fluent([
            'labels' => $labels,
            'data' => $proposals->map(
                fn ($ps) => $ps->countBy(fn ($p) => $p->status)
            )->map(fn ($g) => $g->get('complete') ?? 0)->values(),
        ]);
    }

    protected function discussionsRatings()
    {
        $discussionRatings = [];
        foreach ($this->allDiscussions as $discussion) {
            $title = $discussion['title'];
            $rating = $discussion->rating;
            if (!isset($discussionRatings[$title])) {
                $discussionRatings[$title] = [
                    'totalRating' => 0,
                    'totalCount' => 0,
                    'title' => $title,
                ];
            }
            if ($rating !== null) {
                $discussionRatings[$title]['totalRating'] += $rating;
                $discussionRatings[$title]['totalCount']++;
            }
        }
        foreach ($discussionRatings as $title => $data) {
            if ($data['totalCount'] > 0) {
                $averageRating = $data['totalRating'] / $data['totalCount'];
                $discussionRatings[$title]['averageRating'] = $averageRating;
            }
        }
        $this->discussionData = $discussionRatings;
    }
}
