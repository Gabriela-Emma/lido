<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ErrorsLayout extends Component
{
    public function __construct(
        public string $title = ''
    ) {
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): Factory|View|Application
    {
        return view('layouts.errors');
    }
}
