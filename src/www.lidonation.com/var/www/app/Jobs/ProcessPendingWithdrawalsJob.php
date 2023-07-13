<?php

namespace App\Jobs;

use App\Enums\RoleEnum;
use App\Models\Nft;
use App\Models\Withdrawal;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProcessPendingWithdrawalsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     *
     * @throws RequestException
     * @throws Exception
     */
    public function handle(): void
    {
        $msg = 'Lido Rewards Withdrawal';
        $payments = collect([]);
        $nfts = collect([]);
        
        // get all pending withdrawals or bail
        $withdrawals = Withdrawal::validated()
            ->get()
            ->filter(fn ($w) => ! isset($w->meta_data?->withdrawal_tx));

        if ($withdrawals->isEmpty()) {
            Log::info('No Withdrawal to process');

            return;
        }

        foreach ($withdrawals as $withdrawal) {
            $assetTypes = ['lovelace', 'ft', 'nft'];
            $assets = $withdrawal->rewards->whereIn('asset_type', $assetTypes)
                ->groupBy('asset')
                ->map(fn ($group) => $group->sum('amount'))
                ->toArray();
            $nftRewards = $withdrawal->rewards->whereNotIn('asset_type', $assetTypes);

            foreach ($nftRewards as $nftReward) {
                $nft = Nft::where('user_id', $nftReward->user_id)
                        ->where('policy', $nftReward->asset_type)
                        ->first();

                $metadata = array_merge($nft->metadata?->toArray() ?? [], [
                    'name' => $nft->name,
                    'image' => $nft->storage_link,
                    'factoid' => breakLongText($nft->description, 44, 44, ' '),
                    'homepage' => 'lidonation.com',
                    'artist' => $nft->artist->name,
                    'files' => [
                        [
                            'src' => $nft->storage_link,
                            'name' => $nft->name,
                            'mediaType' => 'image/jpg',
                        ],
                    ],
                ]);

                $nfts->push([
                    'key' => Str::remove(' ', $nft->name),
                    'owner' => $nft->owner_address,
                    'qty' => 1,
                    'metadata' => $metadata,
                ]);
            }

            if (! isset($assets['lovelace']) && $withdrawal->txs?->isEmpty() && ! $withdrawal->user->hasRole(RoleEnum::delegator()->value)) {
                Log::error('Missing Min UTXO');

                continue;
            }

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
            $payments->push(array_merge(['address' => $withdrawal->wallet_address], $assets));
        
        }

        // send them to lucid
        $seed = file_get_contents('/data/phuffycoin/wallets/mint/seed.txt');
        $data = compact('payments', 'msg', 'seed', 'nfts');

        $res = Http::post(
            config('cardano.lucidEndpoint').'/rewards/withdraw',
            $data
        )->throw();

        if ($res->successful()) {
            $tx = $res->object()->tx;
            foreach ($withdrawals as $withdrawal) {
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

    /**
     * Get the middleware the job should pass through.
     */
    public function middleware(): array
    {
        return [];
    }
}
