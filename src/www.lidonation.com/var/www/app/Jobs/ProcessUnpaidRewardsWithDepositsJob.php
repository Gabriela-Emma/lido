<?php

namespace App\Jobs;

use App\Models\Reward;
use App\Models\Tx;
use App\Models\Withdrawal;
use App\Services\CardanoBlockfrostService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Fluent;

class ProcessUnpaidRewardsWithDepositsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected string $depositAddress)
    {
    }

    public function handle(CardanoBlockfrostService $cardanoBlockfrostService): void
    {
        $txs = $cardanoBlockfrostService->get("addresses/{$this->depositAddress}/transactions/", ['order' => 'desc'])
            ->collect();

        $processedTxs = Tx::whereIn('hash', $txs->pluck('tx_hash'))->get('hash');
        $txs = $txs->filter(fn ($t) => $processedTxs->doesntContain('hash', $t['tx_hash']));
        $deposits = collect([]);
        foreach ($txs as $tx) {
            $hash = $tx['tx_hash'];
            $cardanoService = app('cardanoService');
            $res = $cardanoService->tx($hash);
            if ($res->successful()) {
                $utxos = $cardanoService->get("/txs/{$hash}/utxos", [])->object();
                $outputs = collect($utxos->outputs);
                $inputs = collect($utxos->inputs);
                $sender = $inputs->first();
                $deposit = $outputs?->firstWhere(function ($output) {
                    $amounts = collect($output->amount);

                    return $output->address == $this->depositAddress
                        && $amounts->contains('unit', 'lovelace')
                        && $amounts->contains('quantity', '2000000');
                });

                if (! $deposit) {
                    continue;
                }
                $deposits->push(new Fluent([
                    'sender' => $sender,
                    'deposit' => $deposit,
                ]));
            } elseif ($res->status() !== 404) {
                Log::warning('Trouble updating tx', $res->collect()->toArray(0));
            }
        }

        // get senders stake addresses
        $deposits = $deposits->map(function ($dep) {
            $res = app('cardanoService')->get("/addresses/{$dep->sender->address}", []);
            if ($res->failed()) {
                return true;
            }
            $dep->sender->stake_address = $res->object()?->stake_address[0];

            return $dep;
        })->filter(fn ($dep) => (bool) $dep->sender->stake_address);

        $rewards = Reward::whereIn('stake_address', $deposits->pluck('sender.stake_address'))
            ->doesntHave('withdrawal')->get();
        $withdrawalGroups = $rewards->groupBy('stake_address');
        foreach ($withdrawalGroups as $group) {
            $template = $group[0];
            $deposit = $deposits->firstWhere('sender.stake_address', $template->stake_address);
            if (! $deposit) {
                continue;
            }

            // create new withdrawal
            $withdrawal = new Withdrawal;
            $withdrawal->status = 'processing';
            $withdrawal->user_id = $template->user_id;
            $withdrawal->wallet_address = $deposit->sender->address;
            $withdrawal->created_at = now();
            $withdrawal->save();

            // attach rewards to withdrawal
            foreach ($group as $reward) {
                $reward->withdrawal_id = $withdrawal->id;
                $reward->save();
            }

            // document deposit tx
            $tx = new Tx;
            $tx->status = 'paid';
            $tx->quantity = 2000000; //@todo account for multiple deposits. Only works if we time bound the deposits so maybe ignore for now until each deposit gets its own wallet...maybe each lido user?
            $tx->user_id = $template->user_id;
            $tx->model_id = $withdrawal->id;
            $tx->model_type = $withdrawal::class;
            $tx->hash = $deposit->sender->tx_hash;
            $tx->address = $deposit->sender->address;
            $tx->save(); // this should auto validate withdrawal

            // double check withdrawal is validated
            $withdrawal = $withdrawal->refresh();
            if ($withdrawal->status === 'processing' && $withdrawal->txs->isNotEmpty()) {
                $withdrawal->status = 'validated';
                $withdrawal->save();
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
