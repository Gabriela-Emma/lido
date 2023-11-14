<?php

namespace App\Livewire;

use App\Models\Stats;
use App\Repositories\EpochRepository;
use App\Repositories\PoolRepository;
use App\Services\CardanoGraphQLService;
use App\Services\DbSyncService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Fluent;
use Livewire\Component;

class CardanoStatsComponent extends Component
{
    public ?int $cardanoStakedAddresses;

    public ?int $totalPools;

    public ?int $currEpochNo;

    public function mount(): void
    {
        $stats = Stats::whereIn(
            'key',
            [
                'total_staked_address',
                'total_pools',
                'curr_epoch',
            ]
        )->get(['key', 'value'])
            ->map(fn ($stats) => ([$stats['key'] => intval($stats['value'])]))
            ->collapse();

        // turn array into object
        $stats = new Fluent($stats);

        $this->cardanoStakedAddresses = $stats->total_staked_address ?? null;
        $this->totalPools = $stats->total_pools ?? null;
        $this->currEpochNo = $stats->curr_epoch ?? null;
    }

    /**
     * @throws GuzzleException
     */
    public function render(PoolRepository $pools, EpochRepository $epochs, DbSyncService $dbSyncService, CardanoGraphQLService $graphQLService): Factory|View|Application
    {
        return view('livewire.components.cardano-stats');
    }

    public function placeholder()
    {
        return view('components.placeholder.cardano-stats-placeholder');
    }
}
