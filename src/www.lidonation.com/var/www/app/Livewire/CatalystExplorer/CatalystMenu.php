<?php

namespace App\Livewire\CatalystExplorer;

use Livewire\Component;
use App\Invokables\GetCatalystMenu;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class CatalystMenu extends Component
{    
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $catalystMenu = (new GetCatalystMenu)();

        return view('livewire.catalyst-explorer.catalyst-menu', compact('catalystMenu'));
    }
}
