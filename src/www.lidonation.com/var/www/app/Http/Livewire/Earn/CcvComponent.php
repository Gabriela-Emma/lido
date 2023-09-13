<?php

namespace App\Http\Livewire\Earn;

use App\Models\Promo;
use Livewire\Component;

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
