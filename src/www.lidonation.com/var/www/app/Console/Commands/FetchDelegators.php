<?php

namespace App\Console\Commands;

use App\Jobs\FetchUserDelegationJob;
use App\Models\User;
use Illuminate\Console\Command;

class FetchDelegators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:fetch-delegators';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Updates user's active_pool_id column based on user wallet_stake_address not being null";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userIds = User::whereNotNull('wallet_stake_address')
            ->pluck('id')
            ->toArray();

        foreach ($userIds as $userId) {
            FetchUserDelegationJob::dispatch($userId);
        }
    }
}
