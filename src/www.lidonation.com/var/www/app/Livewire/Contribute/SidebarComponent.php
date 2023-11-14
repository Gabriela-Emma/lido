<?php

namespace App\Livewire\Contribute;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SidebarComponent extends Component
{
    public function render(): Factory|View|Application
    {
        return view('livewire.contribute.sidebar');
    }
}
