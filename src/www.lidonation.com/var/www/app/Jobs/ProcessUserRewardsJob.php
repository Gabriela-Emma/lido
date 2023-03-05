<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Withdrawal;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Perform any checks and set reward to waiting (for distribution)
 */
class ProcessUserRewardsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected User $user, protected $payoutAddress)
    {
    }

    /**
     * Execute the job.
     *
     *
     * @throws RequestException
     * @throws Exception
     */
    public function handle(): void
    {
        $withdrawal = new Withdrawal;
        $withdrawal->wallet_address = $this->payoutAddress;
        $withdrawal->status = 'pending';
        $withdrawal->user_id = $this->user?->getAuthIdentifier();
        $withdrawal->save();
        $this->user?->rewards()->whereIn('status', ['issued'])->get()
            ?->each(function ($reward) use ($withdrawal) {
                $reward->status = 'processed';
                $reward->withdrawal_id = $withdrawal->id;
                $reward->save();
            });

        // get all orphan rewards not associated with a withdrawal and lump in.
        $this->user?->rewards()->whereIn('status', ['processed'])->get()
            ?->each(function ($reward) use ($withdrawal) {
                if (! $reward?->withdrawal_id) {
                    $reward->status = 'processed';
                    $reward->withdrawal_id = $withdrawal->id;
                    $reward->save();
                }
            });
    }

    /**
     * Get the middleware the job should pass through.
     */
    public function middleware(): array
    {
        return [];
    }
}
