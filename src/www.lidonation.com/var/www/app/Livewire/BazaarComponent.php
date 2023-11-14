<?php

namespace App\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class BazaarComponent extends Component
{

    public string $metaTitle = 'LIDO Bazaar';

    public function mount()
    {
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.bazaar');
    }
}
