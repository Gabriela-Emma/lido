<?php

namespace App\Jobs;

use App\Services\CardanoBlockfrostService;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchUserDelegationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected int $userId)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::where('id', $this->userId)->first();

        $userAccDetails = app(CardanoBlockfrostService::class)
            ->get('accounts/'.$user->wallet_stake_address, null)
            ->collect();

        if ($userAccDetails['active']) {
            $user->active_pool_id = $userAccDetails['pool_id'];
            $user->save();
        }
    }
}
