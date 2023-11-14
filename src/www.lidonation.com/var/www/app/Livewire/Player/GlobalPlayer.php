<?php

namespace App\Livewire\Player;

use App\Models\Podcast;
use App\Models\Promo;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use App\Repositories\FundRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;

class GlobalPlayer extends Component
{
    public $promo;

    public Collection $podcasts;

    public function mount():void
    {
        $this->promo = Promo::inRandomOrder()->first();
        $this->podcasts = Podcast::get();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.player.global-player');
    }
}
