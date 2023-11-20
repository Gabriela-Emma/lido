<?php

namespace App\Livewire\Player;

use App\Models\Podcast;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Playlist extends Component
{
    public Collection $podcasts;

    public function mount()
    {
        $this->podcasts = Podcast::get();
    }

    public function render()
    {
        return view('livewire.player.playlist');
    }
}
