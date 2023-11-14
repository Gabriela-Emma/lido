<?php

namespace App\Livewire\Library;
use App\Models\Podcast;
use Livewire\Component;

class PodcastContentComponent extends Component
{
    public $newEpisodes;

    public function mount()
    {
        // Fetch the latest episodes
        $this->newEpisodes = Podcast::latest()->take(3)->get();
    }
    public function render()
    {
        return view('livewire.library.podcast-content-component');
    }
}
