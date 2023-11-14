<?php

namespace App\Livewire\Phuffycoin;

use App\Http\Requests\BlockfrostRequest;
use Livewire\Component;

class EscrowWalletComponent extends Component
{
    public $escrowWalletBalance;

    public $escrowCirculation;

    public $txs;

    public function treasurerWallet()
    {

        $walletAddress = $walletAddress ?? config('cardano.mint.addresses.escrow');
        $blockfrostReq = new BlockfrostRequest('/addresses/'.$walletAddress);
        $response = $blockfrostReq->send();

        $this->escrowWalletBalance = $response->json()['amount'][0]['quantity'] / 1000000;
    }

    public function getTransactionCount()
    {
        $walletAddress = $walletAddress ?? config('cardano.mint.addresses.treasurer');
        $blockfrostReq = new BlockfrostRequest('/addresses/'.$walletAddress.'/transactions');
        $response = $blockfrostReq->send();
        // dd($response->json());
        $this->txs = count($response->json());

    }

    public function render()
    {
        $this->treasurerWallet();
        $this->getTransactionCount();

        return view('livewire.phuffycoin.escrow-wallet-component');
    }
}
