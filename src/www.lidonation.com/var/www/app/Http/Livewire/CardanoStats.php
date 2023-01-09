<?php

namespace App\Http\Livewire;

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

class CardanoStats extends Component
{
    public $readyToLoad = false;

    public ?int $cardanoStakedAddresses;

    public ?int $totalPools;

    public ?int $currEpochNo;

    public function loadStats()
    {
        $this->readyToLoad = true;
    }

    /**
     * @throws GuzzleException
     */
    public function render(PoolRepository $pools, EpochRepository $epochs, DbSyncService $dbSyncService, CardanoGraphQLService $graphQLService): Factory|View|Application
    {
        if ($this->readyToLoad) {
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

        return view('livewire.cardano-stats');
    }
}
