<?php

namespace App\Livewire\Components;

use Livewire\Component;

class LidoMinute extends Component
{
    public $latestLidoMinute;
    public function mount($latestLidoMinute)
    {
        $this->latestLidoMinute = $latestLidoMinute;
    }
    public function render()
    {
        return view('livewire.components.lido-minute');
    }
}
