<?php

namespace App\Livewire\Earn;

use App\Models\Promo;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('livewire.earn.layout')]
class CcvComponent extends Component
{
    public $partnerPromo;

    public $giveway;

    public $rewardPot;

    public $metaTitle = 'Catalyst Circle Voting (ccv4)';

    public function mount(): void
    {
        $this->partnerPromo = Promo::inRandomOrder()->first();
    }

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.earn.app');
    }

    protected function dispatchErrors(): void
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
