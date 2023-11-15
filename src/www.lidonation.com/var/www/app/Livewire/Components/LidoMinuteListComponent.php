<?php declare(strict_types=1);

namespace App\Livewire\Components;

use App\Models\Podcast;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class LidoMinuteListComponent extends Component
{
    public $newEpisodes;

    public function mount(): void
    {
        // Fetch the latest episodes
        $this->newEpisodes = Podcast::latest()->take(3)->get();
    }
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.components.lido-minute-list-component');
    }
}
