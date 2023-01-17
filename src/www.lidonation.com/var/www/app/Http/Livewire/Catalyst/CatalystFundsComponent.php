<?php

namespace App\Http\Livewire\Catalyst;

use App\Models\Fund;
use App\Models\Proposal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class CatalystFundsComponent extends Component
{
    use WithPagination;

    public Collection|array $catalystFunds;

    public $quickPitches;

    public int $completedProposalsFilter = 0;

    public int $perPage = 16;

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

    protected LengthAwarePaginator $paginator;

    public function query()
    {
        $this->totalProposalsCount = DB::table('proposals')
            ->where('type', 'proposal')
            ->count();

        $this->completedProposalsCount = Proposal::where(['status' => 'complete'])->count();

        $this->quickPitches = Proposal::whereRelation('metas', 'key', '=', 'quick_pitch')
            ->whereRelation('fund.parent', 'id', '=', 97)
            ->inRandomOrder()
            ->limit(8)
            ->get();

        $this->fundedProposalsCount = DB::table('proposals')
            ->where('type', 'proposal')
            ->whereNotNull('funded_at')
            ->count();

        $this->totalAmountRequested = DB::table('proposals')
            ->where('type', 'proposal')
            ->sum('amount_requested');

        $this->totalAmountAwarded = DB::table('proposals')
            ->where('type', 'proposal')
            ->whereNotNull('funded_at')
            ->sum('amount_requested');

        $this->paginator = Fund::funds()
            ->withSum(
                [
                    'parent_proposals as proposals_amount_requested' => function ($query) {
                        $query->whereNotNull('funded_at')->where('proposals.type', 'proposal');
                    },
                ],
                'amount_requested'
            )
            ->withCount(
                [
                    'parent_proposals as funded_proposals_count' => function ($query) {
                        $query->whereNotNull('funded_at')->where('proposals.type', 'proposal');
                    },
                ])
            ->paginate($this->perPage);

        $this->catalystFunds = $this->paginator->items();

        $this->catalystFundsCount = $this->paginator?->total();
        $this->metrics = $this->paginator->items()[0];
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

        return view('livewire.catalyst.proposal.funds')->layoutData([
            'metaTitle' => $this->metaTitle,
        ]);
    }
}
