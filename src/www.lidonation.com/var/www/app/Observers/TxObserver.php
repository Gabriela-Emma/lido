<?php

namespace App\Observers;

use App\Jobs\MintNftTxJob;
use App\Jobs\UpdateTxJob;
use App\Models\Nft;
use App\Models\Reward;
use App\Models\Tx;
use App\Models\Withdrawal;

class TxObserver
{
    public function created(Tx $tx): void
    {
        switch ($tx->model::class) {
            case Nft::class:
                $this->dispatchMintingJob($tx);
                break;
            case Reward::class:
                $this->dispatchLidoRewardPaymentJob($tx);
                break;
            case Withdrawal::class:
                $this->dispatchLidoWithdrawalPaymentJob($tx);
                break;
        }
    }

    protected function dispatchMintingJob(Tx $tx): void
    {
        // start a recursive queue job that use a ProvidesCardanoService api to fetch tx data
        UpdateTxJob::dispatch(
            $tx->hash,
            file_get_contents('/data/nfts/lido-minute/wallets/mint/seed.txt'),
            MintNftTxJob::class,
            'minting'
        );
    }

    protected function dispatchLidoRewardPaymentJob(Tx $tx): void
    {
        UpdateTxJob::dispatch(
            $tx->hash,
            $tx->model?->wallets?->first(),
            Reward::class,
            'processed'
        );
    }

    protected function dispatchLidoWithdrawalPaymentJob(Tx $tx): void
    {
        UpdateTxJob::dispatch(
            $tx->hash,
            file_get_contents('/data/phuffycoin/wallets/mint/seed.txt'),
            null,
            'validated'
        );
    }
}
