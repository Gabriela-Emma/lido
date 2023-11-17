<?php

namespace App\Livewire\Phuffycoin;

use App\Http\Requests\BlockfrostRequest;
use Livewire\Component;

class EligiblePhuffyComponent extends Component
{
    public $eligiblePhuffyTotal;

    public function getPhuffyTotal()
    {
        $policyId = $policyId ?? config('cardano.mint.policies.phuffycoin');
        $blockfrostReq = new BlockfrostRequest('/assets/policy/'.$policyId);
        $response = $blockfrostReq->send();
        if ($response->json() && isset($response->json()[0])) {
            $response->json()[0]['quantity'];
            $this->eligiblePhuffyTotal = $response->json()[0]['quantity'];
        }

    }

    public function render()
    {
        $this->getPhuffyTotal();

        return view('livewire.phuffycoin.eligible-phuffy-component');
    }
}
