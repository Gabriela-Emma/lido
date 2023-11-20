<?php

namespace App\Livewire\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LibraryPostCount extends Component
{
    public function render(): View|Closure|string
    {
        return view('livewire.components.library-post-count');
    }
}
