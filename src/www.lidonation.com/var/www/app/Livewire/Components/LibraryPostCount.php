<?php

namespace App\Livewire\Components;

use Closure;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class LibraryPostCount extends Component
{

    public function render(): View|Closure|string
    {
        return view('livewire.components.library-post-count');
    }
}
