<?php

namespace App\Livewire\Components;

use App\Invokables\GetLidoMenu;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class LidoMenu extends Component
{
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $lidoMenu = (new GetLidoMenu)();

        return view('livewire.components.lido-menu', compact('lidoMenu'));
    }
}
