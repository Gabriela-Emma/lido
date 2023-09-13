<?php

namespace App\Http\Livewire\Catalyst;

use App\Models\Fund;
use App\Models\Proposal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Scout\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CatalystFundComponent extends Component
{
    use WithPagination;

    public Collection|array $challenges;

    protected LengthAwarePaginator $paginator;

    public $fund;

    public $quickPitches;

    public int $perPage = 24;

    public array $snippets = [];

    public string $sortOrder = 'desc';

    public string $sortBy = 'yes_votes_count';

    public ?string $search = null;

    public $locale = null;

    public string $metaTitle = 'Catalyst Funds';

    // metrics
    public int $catalystFundsCount;

    public int $totalProposalsCount;

    public int $fundedProposalsCount;

    public int $totalAmountRequested;

    public int $totalAmountAwarded;

    public int $completedProposalsCount;

    protected Builder $searchBuilder;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function query()
    {
        $this->fund = Fund::where('slug', '=', request()->route('fund'))
            ->with(['fundChallenges'])
            ->first();

        $type = match ($this->fund?->type) {
            'challenge_setting' => 'challenge',
            default => 'proposal'
        };

        if ($this->fund?->status === 'governance') {
            $this->quickPitches = Proposal::whereRelation('metas', 'key', '=', 'quick_pitch')
                ->whereRelation('fund.parent', 'id', '=', 97)
                ->inRandomOrder()
                ->limit(8)
                ->get();
        }

        $this->completedProposalsCount = Proposal::where([
            'status' => 'complete',
            'type' => $type,
        ])
            ->whereIn('fund_id', $this->fund?->fundChallenges->pluck('id'))
            ->count();

        $this->totalProposalsCount = Proposal::where('type', $type)
            ->whereIn('fund_id', $this->fund?->fundChallenges->pluck('id'))
            ->count();

        $this->fundedProposalsCount = Proposal::where('type', $type)
            ->whereNotNull('funded_at')
            ->whereIn('fund_id', $this->fund?->fundChallenges->pluck('id'))
            ->count();

        $this->totalAmountRequested = Proposal::where('type', $type)
            ->whereIn('fund_id', $this->fund?->fundChallenges->pluck('id'))
            ->sum('amount_requested');

        $this->totalAmountAwarded = Proposal::where('type', $type)
            ->whereNotNull('funded_at')
            ->whereIn('fund_id', $this->fund?->fundChallenges->pluck('id'))
            ->sum('amount_requested');

        $this->paginator = $this->fund->fundChallenges()
            ->withCount(
                [
                    'proposals as funded_proposals_count' => function ($query) use ($type) {
                        $query->whereNotNull('funded_at')->where('type', $type);
                    }, ],
            )->orderBy('title', 'desc')->fastPaginate($this->perPage);

        $this->challenges = $this->paginator->items();

        $this->metaTitle = $this->fund->label;
    }

    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
    }

    public function mount()
    {
        $this->locale = app()->getLocale();
    }

    public function render(): Factory|View|Application
    {
        app()->setLocale($this->locale);
        $this->query();

        return view('livewire.catalyst.proposal.fund')->layoutData([
            'metaTitle' => $this->metaTitle,
        ]);
    }
}
