<?php

namespace App\Jobs;

use App\Models\LearningLesson;
use App\Models\LearningTopic;
use App\Models\Nft;
use App\Models\Tx;
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
        if (! $payments) {
            $jobs = $this->getBatchPaymentsArr();

            if ((bool) $jobs) {
                Bus::batch([
                    function () use ($jobs) {
                        collect($jobs)->each(function ($job) {
                            dispatch(new self($job['payments'], $job['msg'], $job['processWithdrawals']))->delay(now()->addMinutes(3));
                        });
                    },
                ])->dispatch();
            }
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

                    $withdrawal->rewards->each(function ($reward) use ($tx, $withdrawal) {
                        $reward->status = 'paid';
                        $reward->save();

                        if ($reward->model_type == Nft::class) {
                            $nft = Nft::where('user_id', $reward->user_id)
                                ->where('policy', $reward->asset_type)
                                ->first();

                            $nft->status = 'minted';
                            $nft->owner_address = $withdrawal->wallet_address;
                            $nft->save();

                            //save transaction details
                            $newTx = new Tx();
                            $newTx->user_id = $nft->user_id;
                            $newTx->model_id = $nft->id;
                            $newTx->model_type = $nft::class;
                            $newTx->policy = $nft->policy;
                            $newTx->hash = $tx;
                            $newTx->address = $nft->owner_address;
                            $newTx->status = 'minted';
                            $newTx->quantity = $nft->qty;
                            $newTx->metadata = $nft->metadata;
                            $newTx->minted_at = now();
                            $newTx->save();
                        }
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

        if (! $withdrawals) {
            return;
        }

        [$allPayments, $msg, $hasNfts] = $this->getPayments($withdrawals);

        // process withdrawals in batches based on nft awaiability
        $paymentsLimit = $hasNfts ? 101 : 149;
        $transactionsCount = ceil($allPayments->count() / $paymentsLimit);

        $jobs = [];
        for ($i = 1; $i <= $transactionsCount; $i++) {
            $lastPayment = $i * $paymentsLimit;
            $payments = $allPayments->slice($lastPayment - $paymentsLimit, $paymentsLimit);
            $processWithdrawals = $withdrawals->slice($lastPayment - $paymentsLimit, $paymentsLimit);

            array_push($jobs, ['payments' => $payments, 'msg' => $msg, 'processWithdrawals' => $processWithdrawals]);
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
            $assetTypes = ['lovelace', 'ft', 'nft', 'ada'];
            $assets = $withdrawal->rewards->whereIn('asset_type', $assetTypes)
                ->groupBy('asset')
                ->map(fn ($group) => $group->sum('amount'))
                ->toArray();
            $nftRewards = $withdrawal->rewards->whereNotIn('asset_type', $assetTypes);

            if ($nftRewards->count() != 0) {
                foreach ($nftRewards as $nftReward) {

                    $rewardTopic = LearningLesson::find($nftReward->model_id)->topic->id;

                    if (! $rewardTopic) {
                        continue;
                    }

                    $nft = Nft::where('user_id', $nftReward->user_id)
                        ->where([
                            'model_type' => LearningTopic::class,
                            'model_id' => $rewardTopic,
                        ])
                        ->first();

                    if (! $nft instanceof Nft) {
                        continue;
                    }

                    $metadata = array_merge($nft?->metadata?->toArray() ?? [], [
                        'name' => $nft?->name,
                        'image' => $nft?->storage_link,
                        'homepage' => 'lidonation.com',
                        'artist' => $nft?->artist->name,
                        'description' => breakLongText($nft?->description, 32, 32, ' '),
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
