<?php

namespace App\Jobs;

use App\Models\Giveaway;
use App\Models\Reward;
use App\Models\User;
use App\Services\CardanoBlockfrostService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class IssuePoolRewards implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public string $stakeAddress, public int $epoch, public Giveaway $giveaway)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(CardanoBlockfrostService $blockfrostService): void
    {
        $delegations = $blockfrostService
            ->get("/accounts/{$this->stakeAddress}/history", ['order' => 'desc'])
            ->collect();

        // get user delegation for epoch
        $delegation = $delegations->firstWhere('active_epoch', $this->epoch);
        if (! $delegation) {
            Log::info("Delection for epoch {$this->epoch} not found for {$this->stakeAddress}");

            return;
        }

        // calculate reward at 5% apy
        $apy = $delegation['amount'] * 0.05;

        // if user doesn't already have an account
        // create one
        $user = User::where('wallet_stake_address', $this->stakeAddress)->first();
        if (! $user instanceof User) {
            $user = new User;
            $user->name = $this->stakeAddress;
            $user->wallet_stake_address = $this->stakeAddress;
            $user->email = $request->email ?? substr($this->stakeAddress, -4).'@anonymous.com';
            $user->password = Hash::make(Str::random(10));
            $user->save();
        }

        // create reward object
        $reward = new Reward;
        $reward->user_id = $user->id;
        $reward->asset = 'lovelace';
        $reward->model_id = $this?->giveaway->id;
        $reward->model_type = Giveaway::class;
        $reward->asset_type = 'ada';
        $reward->amount = ceil($apy / 72);
        $reward->status = 'issued';
        $reward->stake_address = $user->wallet_stake_address;
        $reward->setTranslation('memo', 'en', $this->giveaway->title);
        $reward->save();
    }

    /**
     * Get the middleware the job should pass through.
     */
    public function middleware(): array
    {
        return [];
    }
}
