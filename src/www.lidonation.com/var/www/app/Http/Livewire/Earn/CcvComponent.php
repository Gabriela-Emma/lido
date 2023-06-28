<?php

namespace App\Http\Livewire\Earn;

use App\Invokables\GetLidoRewardsPot;
use App\Models\EveryEpoch;
use App\Models\Giveaway;
use App\Models\Promo;
use App\Services\CardanoBlockfrostService;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CcvComponent extends Component
{
    public $partnerPromo;

    public $giveway;

    public $rewardPot;


    public function mount()
    {
        $this->partnerPromo = Promo::inRandomOrder()->first();
    }

    public function render()
    {
        return view('livewire.earn.app')
            ->layout(
                'livewire.earn.layout',
                [
                    'metaTitle' => 'Catalyst Circle Voting (ccv4)',
                ]
            );
    }

    protected function dispatchErrors()
    {
        foreach ($this->getErrorBag()?->getMessages() as $name => $msg) {
            $this->dispatchBrowserEvent('new-notice', [
                'type' => 'error',
                'name' => $name,
                'message' => $msg,
            ]);
        }
    }
}
