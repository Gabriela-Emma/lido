<?php

namespace App\Livewire\Phuffycoin;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.phuffycoin')]
class PhuffycoinRoadmap extends Component
{
    public function render()
    {
        return view('livewire.phuffycoin.phuffycoin-roadmap');
    }
}
