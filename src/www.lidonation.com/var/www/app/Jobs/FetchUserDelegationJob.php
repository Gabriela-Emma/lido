<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\CardanoBlockfrostService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
        try {
            if ($userAccDetails['active'] == true) {
                $user->active_pool_id = $userAccDetails['pool_id'];
                $user->save();
            }
        } catch (\Throwable $th) {
            Log::info('Not an active account');
        }

    }
}
