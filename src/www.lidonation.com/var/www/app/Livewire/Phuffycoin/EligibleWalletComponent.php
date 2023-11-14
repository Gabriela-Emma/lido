<?php

namespace App\Livewire\Phuffycoin;

use App\Http\Requests\BlockfrostRequest;
use Livewire\Component;

class EligibleWalletComponent extends Component
{
    public $eligibleWalletCount;

    public function getSomething()
    {
        $address = '9a556a69ba07adfbbce86cd9af8fd73f60fcf43c73f8deb51d2176b4504855464659';
        $blockfrostReq = new BlockfrostRequest('/assets/'.$address.'/addresses');
        $response = $blockfrostReq->send();

        $this->eligibleWalletCount = count($response->json());

    }

    public function render()
    {
        $this->getSomething();

        return view('livewire.phuffycoin.eligible-wallet-component');
    }
}
