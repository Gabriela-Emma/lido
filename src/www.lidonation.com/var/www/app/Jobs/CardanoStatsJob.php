<?php

namespace App\Jobs;

use App\Models\Stats;
use App\Repositories\EpochRepository;
use App\Services\CardanoGraphQLService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CardanoStatsJob implements ShouldQueue
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
     */
    public function handle(EpochRepository $epochs, CardanoGraphQLService $graphQLService)
    {
        // query data from blockchain
        $stats = collect([
            [
                'total_staked_address',
                'Total Staked Addresses',
                $graphQLService->getStakedAddressesCount(),
            ],

            [
                'total_pools',
                'Total Pools',
                $graphQLService->getStakePoolCount(),
            ],
            [
                'curr_epoch',
                'Current Epoch',
                $epochs->current()?->no,
            ],
        ]);

        $stats->each(function ($stat) {
            // create new stats object (or update an existing)
            $stat = Stats::updateOrCreate(
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
