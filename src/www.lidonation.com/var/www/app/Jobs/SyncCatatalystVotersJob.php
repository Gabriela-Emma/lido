<?php

namespace App\Jobs;

use App\Services\CardanoBlockfrostService;
use Illuminate\Bus\Queueable;
use App\Models\CatalystRegistration;
use App\Models\Delegation;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
            $page = 1;
            do {
                $votersRegistrationTransactions = (new CardanoBlockfrostService)->get(
                    "/metadata/txs/labels/61284",
                    [
                        'count' => 30,
                        'page' => $page,
                        'order' => 'desc'
                    ])->collect();
                
                $votersRegistrationTransactions->each(function($voterTransaction) {
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

                $page++;
                sleep(10);
            } while ($votersRegistrationTransactions->isNotEmpty());
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
            
            // fetch voting_power and transaction time from transaction hash.
            
            $res = Http::post(
                config('cardano.lucidEndpoint').'/votes/decode-voter-transaction',
                compact('voterTransaction')
                )->throw();

            
            // save voter details if $response is succeful
            if ($res->successful()) {
                $votersDetails = new Fluent($res->json()['data']);

                $controlled_amount = $this->getAccountAmount($votersDetails->stake_pub);
                $transaction_time = $this->getTransactionTime($voterTransaction->tx_hash);
                
                //save voter registration details
                $catalystRegistration = new CatalystRegistration();
                $catalystRegistration->tx = $voterTransaction->tx_hash;
                $catalystRegistration->stake_pub = $votersDetails->stake_pub;
                $catalystRegistration->stake_key = $votersDetails->stake_key;
                $catalystRegistration->voting_power = $controlled_amount;
                $catalystRegistration->created_at = $transaction_time;
                $catalystRegistration->save();
                
                $voterDelegations = collect(json_decode($votersDetails->voter_delegations, true));
                $voterDelegations->each(function ($voterDelegation) use($catalystRegistration) {
                    $newDelegation = new Delegation();
                    $newDelegation->catalyst_registration_id = $catalystRegistration->id;
                    $newDelegation->voting_pub = $voterDelegation[0];
                    $newDelegation->weight = $voterDelegation[1];
                    $newDelegation->save();
                });
            }
        }
    }

    protected function getAccountAmount(string $stakeAddress)
    {
        $accountDetails = app(CardanoBlockfrostService::class)
            ->get("accounts/{$stakeAddress}", null)
            ->object();

        return $accountDetails->controlled_amount / 1000000;
    }

    protected function getTransactionTime(string $txHash)
    {
        $transaction = app(CardanoBlockfrostService::class)
            ->get("txs/{$txHash}", null)
            ->object();
    
        return $transaction->block_time;
    }
}
