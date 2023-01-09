<?php

namespace App\Jobs;

use App\Models\Stats;
use App\Repositories\PoolRepository;
use App\Services\CardanoBlockfrostService;
use App\Services\CardanoGraphQLService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LidoStatsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws GuzzleException
     */
    public function handle(PoolRepository $pools, CardanoGraphQLService $graphQLService, CardanoBlockfrostService $cardanoBlockfrostService)
    {
        // query data from blockchain
        $stats = collect([
            [
                'total_blocks',
                'Total Blocks',
                $pools->blocks()?->count(),
            ],
            [
                'epoch_delegations',
                'Epoch Delegations',
                $graphQLService->getPoolDelegationCount(),
            ],
            [
                'paid_to_delegates',
                'Paid to Delegates',
                $graphQLService->getPoolDelegationRewardsSum(),
            ],
            [
                'active_stake',
                'Active Stake',
                $graphQLService->getPoolActiveState(),
            ],
        ]);

        $stats->each(function ($stat) {
            // create new stats object (or update an existing object)
            Stats::updateOrCreate(
                [
                    'key' => $stat[0],
                ],
                [
                    'key' => $stat[0],
                    'label' => $stat[1],
                    'value' => $stat[2],
                ]
            );
        });
    }
}
