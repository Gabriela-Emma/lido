<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Nairobi Cardano Blockchain Lab')]
class LidoBlockchainLabsComponent extends Component
{public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('lido-blockchain-labs');
    }
}
