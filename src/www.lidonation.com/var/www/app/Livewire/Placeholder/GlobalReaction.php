<?php

namespace App\Livewire\Placeholder;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class GlobalReaction extends Component
{
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('placeholder.global-reaction');
    }
}
