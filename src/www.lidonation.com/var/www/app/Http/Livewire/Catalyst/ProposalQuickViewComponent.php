<?php

namespace App\Http\Livewire\Catalyst;

use App\Models\CatalystUser;
use App\Models\Proposal;
use App\Repositories\CatalystUserRepository;
use App\Repositories\FundRepository;
use App\Repositories\PostRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Fluent;
use LivewireUI\Modal\ModalComponent;

class ProposalQuickViewComponent extends ModalComponent
{
    public int $proposalId;

    public Proposal $proposal;

    public CatalystUser $catalystUser;

    public $allTimeCaAverage;

    public $allTimeCaRatingCount;

    public $allTimeCaAverageGroups;

    private Fluent $allTimeFundingPerRound;

    private Fluent $allTimeCompletedPerRound;

    private Fluent $allTimeFundedPerRound;

    private Fluent $allTimeAwardedPerRound;

    private Fluent $allTimeReceivedPerRound;

    private Fluent $allTimeProposedPerRound;

    public ?bool $submittingVote = true;

    public ?bool $voteSubmitted = false;

    protected $listeners = [
        'upvoteProposal' => 'upvoteProposal',
        'submitProposal' => 'submitProposal',
    ];

    // form
    public ?string $name = null;

    public ?string $idea = null;

    protected array $rules = [];

    public function getChartData($data)
    {
        return $this->{$data};
    }

    public function upvoteProposal()
    {
        $this->submittingVote = false;
    }

    public function downVoteProposal()
    {
        $this->submittingVote = false;
    }

    public function reset(...$properties)
    {
        parent::reset($properties);
        $this->submittingVote = false;
    }

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function mount(int $proposalId, CatalystUserRepository $catalystUserRepository, FundRepository $fundRepository)
    {
        $this->proposal = Proposal::findOrFail($proposalId);
        $this->catalystUser = $catalystUserRepository->get($this->proposal->users?->first()?->id);
        //
        $discussions = $this->catalystUser?->proposals
            ->map(
                fn ($p) => $p->discussions
            )->collapse();

        // combined ratings across all CA reviews
        $ratings = $discussions->map(fn ($disc) => $disc->ratings)->collapse();
        $this->allTimeCaRatingCount = $ratings->count();
        $this->allTimeCaAverage = $ratings->avg('rating');

        // combined ratings by discussion
        $this->allTimeCaAverageGroups = $ratings->map(fn ($v) => ([
            'rating' => $v->rating,
            'review' => $v->model->title,
        ]))->groupBy('review')
            ->map(
                fn ($v, $k) => [
                    'rating' => round($v->avg('rating'), 2),
                    'percent' => intval(round($v->avg('rating') / 5 * 100)),
                ]
            );

        $proposalGroups = $fundRepository->funds('funds')->map(
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
            )->map(fn ($g) => $g->get('funded') ?? 0)->values(),
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

    public function render(PostRepository $posts, CatalystUserRepository $catalystUserRepository): Factory|View|Application
    {
        return view('livewire.catalyst.proposal.quickview');
    }
}
