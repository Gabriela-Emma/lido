<?php

namespace App\Livewire\Phuffycoin;

use App\Http\Requests\BlockfrostRequest;
use Livewire\Component;

class TreasurerWalletComponent extends Component
{
    public $treasurerWalletBalance;

    public $treasurerCirculation;

    public $txs;

    public $phuffyTxs;

    public function treasurerWallet()
    {

        $walletAddress = $walletAddress ?? config('cardano.mint.addresses.treasurer');
        $blockfrostReq = new BlockfrostRequest('/addresses/'.$walletAddress);
        $response = $blockfrostReq->send();

        $this->treasurerWalletBalance = $response->json()['amount'][0]['quantity'] / 1000000;
    }

    public function getTreasurerCirculation()
    {
        $policyId = $policyId ?? config('cardano.mint.policies.phuffycoin');
        $blockfrostReq = new BlockfrostRequest('/assets/policy/'.$policyId);
        $response = $blockfrostReq->send();

        $this->treasurerCirculation = $response->json()[0]['quantity'];
    }

    public function getTransactionCount()
    {
        $walletAddress = $walletAddress ?? config('cardano.mint.addresses.treasurer');
        $blockfrostReq = new BlockfrostRequest('/addresses/'.$walletAddress.'/transactions');
        $response = $blockfrostReq->send();
        $this->txs = $response->json();

        $phuffyTxs = [];
        $normalTxs = [];
        $rewards = [];

        // foreach ($response->json() as $tx) {
        //     $blockfrostReq = new BlockfrostRequest('/txs/'.$tx['tx_hash']);
        //     $response = $blockfrostReq->send()->json();
        //     $outputs = $response['output_amount'];
        //     $units = [];
        //     foreach ($outputs as $output) {
        //         $units[] = $output['unit'];
        //     }

        //     if(in_array('9a556a69ba07adfbbce86cd9af8fd73f60fcf43c73f8deb51d2176b4504855464659', $units)){
        //         $phuffyTxs[] =  $response;
        //     }else{
        //         $normalTxs[] =  $response;
        //     }
        // }
    }

    public function render()
    {
        $this->treasurerWallet();
        $this->getTreasurerCirculation();
        $this->getTransactionCount();
        if (! is_array($this->txs)) {
            $this->txs = [];
        }

        return view('livewire.phuffycoin.treasurer-wallet-component');
    }
}
