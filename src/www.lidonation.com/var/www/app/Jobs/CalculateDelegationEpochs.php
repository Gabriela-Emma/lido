<?php

namespace App\Jobs;

use App\Models\User;
use App\Repositories\EpochRepository;
use App\Services\Traits\DbSyncHelpers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateDelegationEpochs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, DbSyncHelpers;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get all user with a stake address
        $users = User::whereNotNull('wallet_stake_address')->limit(User::count())->cursor();
        foreach ($users as $user) {
            $this->processUser($user);
        }
    }

    /**
     * Query db sync for user delegation epochs and update user delegation_length meta
     *
     * @param  User  $user
     */
    protected function processUser(User $user)
    {
        $epochCount = $this->activeOnEpoch($user->wallet_stake_address);
        $currEpoch = intval(
            (app(EpochRepository::class)->current())?->no
        ) ?? $epochCount;
        $user->saveMeta('delegation_length', count(range($epochCount, $currEpoch)));
    }
}
