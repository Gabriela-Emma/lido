<?php

namespace App\Livewire;

use App\Models\Podcast;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LidoMinute extends Component
{
    public string $metaTitle = 'LIDO Minute Podcast';

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('lido-minute');
    }
}
