<?php

namespace App\Jobs;

use App\Models\Nft;
use App\Models\Withdrawal;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProcessPendingWithdrawalsJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected $payments = null, protected $msg = null, protected $processWithdrawals = null)
    {
        if (!$payments) {
            $jobs = $this->getBatchPaymentsArr();

            Bus::batch([
               function () use($jobs) {
                   collect($jobs)->each(function($job) {
                        dispatch(new self($job['payments'], $job['msg'], $job['processWithdrawals']))->delay(now()->addSeconds(10));
                    });   
               },
            ])->dispatch();
            
        }
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
        if ($this->payments) {
            $payments = $this->payments;
            $msg = $this->msg;
            $seed = file_get_contents('/data/phuffycoin/wallets/mint/seed.txt');
            $data = compact('payments', 'msg', 'seed');
            
            $res = Http::post(
                config('cardano.lucidEndpoint').'/rewards/withdraw',
                $data
            )->throw();

            if ($res->successful()) {
                $tx = $res->object()->tx;
                foreach ($this->processWithdrawals as $withdrawal) {
                    $withdrawal->status = 'paid';
                    $withdrawal->save();

                    //@todo  move this work into an Observer class pretty please
                    $withdrawal->rewards->each(function ($reward) {
                        $reward->status = 'paid';
                        $reward->save();
                    });
                    $withdrawal->saveMeta('withdrawal_tx', $tx, $withdrawal);
                }
            }
        }
        
    }

    protected function getBatchPaymentsArr()
    {
        // query pending withdrawals and destructure to needed payment format
        $withdrawals = $this->getWithdrawals();
        [$allPayments, $msg, $hasNfts] = $this->getPayments($withdrawals);

        // process withdrawals in batches based on nft awaiability
        $paymentsLimit = $hasNfts ? 101 : 149;
        $transactionsCount = ceil($allPayments->count() / $paymentsLimit);

        $jobs = [];
        for ($i = 1; $i <= $transactionsCount; $i++) {
            $lastPayment = $i * $paymentsLimit;
            $payments = $allPayments->slice($lastPayment - $paymentsLimit, $paymentsLimit);
            $processWithdrawals = $withdrawals->slice($lastPayment - $paymentsLimit, $paymentsLimit);
            
            
            array_push($jobs, ['payments'=> $payments, 'msg'=>$msg, 'processWithdrawals'=>$processWithdrawals]);
        }
        
       return $jobs;
    }

    

    protected function getWithdrawals()
    {
        // get all pending withdrawals or bail
        $withdrawals = Withdrawal::validated()
            ->get()
            ->filter(fn ($w) => ! isset($w->meta_data?->withdrawal_tx));

        if ($withdrawals->isEmpty()) {
            Log::info('No Withdrawal to process');

            return;
        }

        return $withdrawals;
    }

    protected function getPayments($withdrawals)
    {
        $msg = 'Lido Rewards Withdrawal';
        $payments = collect([]);
        $nftsCount = 0;
        foreach ($withdrawals as $withdrawal) {
            $nftsArr = [];
            $assetTypes = ['lovelace', 'ft', 'nft'];
            $assets = $withdrawal->rewards->whereIn('asset_type', $assetTypes)
                ->groupBy('asset')
                ->map(fn ($group) => $group->sum('amount'))
                ->toArray();
            $nftRewards = $withdrawal->rewards->whereNotIn('asset_type', $assetTypes);

            if ($nftRewards->count() != 0) {
                foreach ($nftRewards as $nftReward) {
                    $nft = Nft::where('user_id', $nftReward->user_id)
                            ->where('policy', $nftReward->asset_type)
                            ->first();
    
                    $metadata = array_merge($nft?->metadata?->toArray() ?? [], [
                        'name' => $nft?->name,
                        'image' => $nft?->storage_link,
                        'factoid' => breakLongText($nft?->description, 44, 44, ' '),
                        'homepage' => 'lidonation.com',
                        'artist' => $nft?->artist->name,
                        'files' => [
                            [
                                'src' => $nft?->storage_link,
                                'name' => $nft?->name,
                                'mediaType' => 'image/jpg',
                            ],
                        ],
                    ]);
    
                    $nftsArr[] = [
                        'key' => Str::remove(' ', $nft?->name),
                        'owner' => $nft?->owner_address,
                        'qty' => 1,
                        'metadata' => $metadata,
                    ];
                    $nftsCount += 1;
                }
            } 

            // if (! isset($assets['lovelace']) && $withdrawal->txs?->isEmpty() && ! $withdrawal->user->hasRole(RoleEnum::delegator()->value)) {
            //     Log::error('Missing Min UTXO');

            //     continue;
            // }

            if ($withdrawal->txs?->isNotEmpty()) {
                $tx = $withdrawal->txs?->first();
                if ($tx->quantity > 0) {
                    if (isset($assets['lovelace'])) {
                        $assets['lovelace'] += $tx->quantity;
                    } else {
                        $assets['lovelace'] = $tx->quantity;
                    }
                }
            }
            
            $withdrawalNfts = count($nftsArr) != 0 ? $nftsArr : null;
            $payments->push([
                'address' => $withdrawal->wallet_address,
                'assets' => $assets,
                'nfts' => $withdrawalNfts,
            ]);
        }

        $hasNfts = $nftsCount > 0 ? true : false;
        return [$payments, $msg, $hasNfts];
    }

     /**
     * Get the middleware the job should pass through.
     */
    public function middleware(): array
    {
        return [];
    }
}
