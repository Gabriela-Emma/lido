<?php

namespace App\Livewire\Player;

use App\Models\Podcast;
use App\Models\Promo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class GlobalPlayer extends Component
{
    public $promo;

    public Collection $podcasts;

    public function mount(): void
    {
        $this->promo = Promo::inRandomOrder()->first();
        $this->podcasts = Podcast::get();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.player.global-player');
    }
}
