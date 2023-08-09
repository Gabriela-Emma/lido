<?php

namespace App\Jobs;

use App\Services\CardanoBlockfrostService;
use Illuminate\Bus\Queueable;
use App\Models\CatalystRegistration;
use App\Models\Delegation;
use App\Models\Reward;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Fluent;

class SyncCatatalystVotersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    public $timeout = 3600;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected $encodedTransactionDetails = null)
    {
        if (!$encodedTransactionDetails) {
            $votersRegistrationTransactions = (new CardanoBlockfrostService)->get("/metadata/txs/labels/61284", null)->collect();
            $votersRegistrationTransactions->each(function(Array $voterTransaction) {
                $transaction = new Fluent([
                    'tx_hash' => $voterTransaction['tx_hash'],
                    "json_metadata" => new Fluent([
                        "one" => $voterTransaction['json_metadata']['1'],
                        "two" => $voterTransaction['json_metadata']['2'],
                    ]),
                ]);
                
                $voterSavedRegistration = CatalystRegistration::where('tx', $transaction?->tx_hash)->first();

                if (! $voterSavedRegistration instanceof CatalystRegistration) {
                    dispatch(new self($transaction));
                }
            });
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        if ($this->encodedTransactionDetails) {
            $voterTransaction = $this->encodedTransactionDetails;
            $res = Http::post(
                config('cardano.lucidEndpoint').'/votes/decode-voter-transaction',
                compact('voterTransaction')
            )->throw();
    
            if ($res->successful()) {
                $voterDetails = new Fluent($res->json()['data']);
                
                $catalystRegistration = new CatalystRegistration();
                $catalystRegistration->tx = $voterDetails->tx;
                $catalystRegistration->stake_pub = $voterDetails->stake_pub;
                $catalystRegistration->stake_key = $voterDetails->stake_key;
                $catalystRegistration->voting_power = $voterDetails->voting_power;
                $catalystRegistration->created_at = $voterDetails->created_at;
                $catalystRegistration->save();
                
                $voterDelegation = explode(",", $voterDetails->voter_pub);
                $newDelegation = new Delegation();
                $newDelegation->catalyst_registration_id = $catalystRegistration->id;
                $newDelegation->voting_pub = $voterDelegation[0];
                $newDelegation->weight = $voterDelegation[1];
                $newDelegation->save();
    
            }
        }
    }
}
