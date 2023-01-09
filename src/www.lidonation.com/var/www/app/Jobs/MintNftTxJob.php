<?php

namespace App\Jobs;

use App\Invokables\MintNft;
use App\Models\Model;
use App\Models\Tx;
use \Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MintNftTxJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected string $hash)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws RequestException
     * @throws Exception
     */
    public function handle(): void
    {
        $tx = Tx::where('hash', $this->hash)->firstOrFail();
        $hash = (new MintNft)($tx);

        if ($tx->model instanceof Model) {
            $tx->model->status = 'minted';
        }

        $tx->status = 'minted';
        $tx->minted_at = now();
        $tx->metadata['mint_tx_hash'] = $hash;
        $tx->save();
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware(): array
    {
        return [];
    }
}
