<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\CardanoBlockfrostService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PopulatePaymentAddressJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected User $user)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(CardanoBlockfrostService $cardanoBlockfrostService): void
    {
        try {
            $address = $cardanoBlockfrostService->get("accounts/{$this->user->wallet_stake_address}/addresses", null)
                ->throw()
                ->collect()
                ?->first()['address'];

            // @todo confirm that address picked is actually owned by the associated stake key (using the lucid service)
            // Ticket: Ticket-01472
            $frost_stake_key = $cardanoBlockfrostService->get("addresses/$address", null)['stake_address'];
            $address_confirmed = ($frost_stake_key == $this->user->wallet_stake_address) ? true : false;

            if ($address_confirmed) {
                $this->user->wallet_address = $address;
                $this->user->save();
                Log::info('address was confirmed and saved');
            } else {
                Log::error('Failed to update user, address issue.');
            }
        } catch (RequestException $e) {
            Log::error('Failed to update user.', $this->user?->toArray());
        }
    }

    /**
     * Get the middleware the job should pass through.
     */
    public function middleware(): array
    {
        return [(new RateLimited('backups'))];
    }
}
