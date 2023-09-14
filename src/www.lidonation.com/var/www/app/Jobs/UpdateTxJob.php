<?php

namespace App\Jobs;

use App\Contracts\ProvidesCardanoService;
use App\Models\Tx;
use App\Models\Wallet;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateTxJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected string $hash,
        protected Wallet|string $paymentWalletOrSeed,
        protected $effect = null,
        protected $effectStatus = 'minting')
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tx = Tx::where('hash', $this->hash)->first();
        if (! $tx instanceof Tx) {
            return;
        }

        // expire tx after 10 mins
        if ((Carbon::make(now()))->subMinutes(10)->gt($tx->created_at)) {
            $tx->status = 'expired';
            $tx->save();

            return;
        }

        if ((bool) $tx->quantity && $tx->status !== 'pending') {
            if ($tx->status == 'paid') {
                if ($this->effect && in_array(ShouldQueue::class, class_implements($this->effect))) {
                    $this->effect::dispatch($tx->hash)->delay(now()->addSeconds(30));
                    $tx->status = $this->effectStatus;
                    $tx->save();
                } else {
                    $tx->model->status = $this->effectStatus;
                    $tx->model->save();
                }
            }

            return;
        }

        /** @var $cardanoService ProvidesCardanoService */
        $cardanoService = app('cardanoService');

        try {
            $res = $cardanoService->tx($this->hash);
            if ($res->successful()) {
                $hash = $cardanoService->tx($this->hash)->object();

                // get utxos
                if ($hash && $hash?->output_amount) {
                    $utxos = $cardanoService->get("/txs/{$this->hash}/utxos", [])->throw()->object();
                    $this->updateDbTx($tx, $hash, $utxos);
                }
            } elseif ($res->status() !== 404) {
                Log::warning('Trouble updating tx', $res->collect()->toArray(0));

                return;
            }
        } catch (Exception $e) {
            Log::critical($e->getMessage());
        }

        self::dispatch($tx->hash, $this->paymentWalletOrSeed, $this->effect, $this->effectStatus);
    }

    /**
     * Get the middleware the job should pass through.
     */
    public function middleware(): array
    {
        return [(new WithoutOverlapping($this->hash))->releaseAfter(12)];
    }

    protected function updateDbTx(Tx $tx, object $hash, object $utxos)
    {
        $effectWallet = $this->getAddressFromLucid();

        $payment = collect($utxos->outputs)->firstWhere(fn ($output) => $output->address === $effectWallet?->address);
        $lovelaces = collect($payment->amount)->firstWhere(fn ($coin) => $coin->unit === 'lovelace');
        $lovelaces = (int) $lovelaces?->quantity;

        $sender = collect($utxos->outputs)
            ->firstWhere(fn ($coin) => $coin->address !== $effectWallet?->address);

        $tx->address = $sender?->address;
        $tx->status = 'paid';
        $tx->quantity = $lovelaces;
        $tx->metadata = [
            'block' => $hash->block,
            'slot' => $hash->slot,
        ];
        $tx->save();
    }

    protected function getAddressFromLucid(): object|array|null
    {
        $seed = $this->paymentWalletOrSeed?->passphrase ?? $this->paymentWalletOrSeed;

        return Http::post(
            config('cardano.lucidEndpoint').'/wallet/address',
            compact('seed')
        )->throw()->object();
    }
}
