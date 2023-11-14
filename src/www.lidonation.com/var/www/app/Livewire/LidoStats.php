<?php

namespace App\Livewire;

use App\Models\Stats;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Fluent;
use Livewire\Component;

class LidoStats extends Component
{
    public ?int $totalPools;

    public ?int $totalBlocks;

    public ?int $epochDelegations;

    public $paidToDelegates;

    public $epochDelegationAmount;

    public $readyToLoad = false;

    protected $preRenderedView = false;

    public function mount()
    {
        $stats = Stats::whereIn(
            'key',
            [
                'total_blocks',
                'epoch_delegations',
                'paid_to_delegates',
                'active_stake',
            ]
        )->get(['key', 'value'])
            ->map(fn ($stats) => ([$stats['key'] => $stats['value']]))
            ->collapse();

        // turn array into object
        $stats = new Fluent($stats);

        $this->totalBlocks = $stats->total_blocks;
        $this->epochDelegations = $stats->epoch_delegations;
        $this->epochDelegationAmount = $stats->active_stake;
        $this->paidToDelegates = $stats->paid_to_delegates;
    }

    /**
     * @throws GuzzleException
     */
    public function render(): Factory|View|Application
    {
        return view('livewire.components.lido-stats');
    }

    public function placeholder()
    {
        return view('components.placeholder.lido-stats-placeholder');
    }
}
