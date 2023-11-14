<?php

namespace App\Livewire\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class SupportLidoComponent extends Component
{
    public string $theme;

    public string $title = 'Support Lido Nation';

    public ?string $subtitle;

    public ?string $cta;

    public $links = [
        'delegate',
        'bazaar',
        'podcast',
    ];

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.components.support-lido');
    }

    public function placeholder(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('components.placeholder.support-lido-placeholder');
    }
}
