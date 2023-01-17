<?php

namespace App\Console\Commands;

use App\Jobs\RecordCcv4BallotsJob;
use App\Services\CardanoBlockfrostService;
use Illuminate\Console\Command;

class SyncCcv4BallotsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:sync-ccv4-ballots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync CCV4 BAllots';

    public function handle(CardanoBlockfrostService $cardanoBlockfrostService)
    {
        $page = 1;
        do {
            $ballots = $cardanoBlockfrostService->get(
                '/assets/c40fe3d8d97b3af86a3bbfa7dfa41ca2be2a82a5d91e4b8db7cc60c542616c6c6f74/transactions',
                ['count' => 30,
                    'page' => $page,
                ])->collect();

            $ballots->each(fn ($ballot) => RecordCcv4BallotsJob::dispatch(
                $ballot['tx_hash'],
                $ballot['block_height'],
                $ballot['block_time']
            ));
            $page++;
            sleep(10);
        } while ($ballots->isNotEmpty());
    }
}
