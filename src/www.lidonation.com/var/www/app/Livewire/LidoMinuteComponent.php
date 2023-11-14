<?php

namespace App\Livewire;

use App\Models\Podcast;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LidoMinuteComponent extends Component
{
    public $newEpisodes;

    public string $metaTitle = 'LIDO Minute Podcast';

    public function mount()
    {
        $this->newEpisodes = Podcast::orderBy('published_at')->limit(5)->get();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('lido-minute');
    }
}
