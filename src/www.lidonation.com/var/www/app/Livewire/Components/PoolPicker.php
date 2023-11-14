<?php

namespace App\Livewire\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PoolPicker extends Component
{
    public $title = 'Staking with LIDO';

    public $theme = 'white';

    public function render(): Factory|View|Application
    {
        return view('livewire.components.pool-picker');
    }
}
