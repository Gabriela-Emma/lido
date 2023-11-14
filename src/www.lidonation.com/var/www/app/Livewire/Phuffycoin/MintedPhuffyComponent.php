<?php

namespace App\Livewire\Phuffycoin;

use App\Http\Requests\BlockfrostRequest;
use Livewire\Component;

class MintedPhuffyComponent extends Component
{
    public $currentMintedPhuffy;

    public function getMintedPhuffy()
    {
        $policyId = $policyId ?? config('cardano.mint.policies.phuffycoin');
        $blockfrostReq = new BlockfrostRequest('/assets/policy/'.$policyId);
        $response = $blockfrostReq->send();

        if ($response->json() && isset($response->json()[0])) {
            $this->currentMintedPhuffy = $response->json()[0]['quantity'];
        }
    }

    public function render()
    {
        $this->getMintedPhuffy();

        return view('livewire.phuffycoin.minted-phuffy-component');
    }
}
