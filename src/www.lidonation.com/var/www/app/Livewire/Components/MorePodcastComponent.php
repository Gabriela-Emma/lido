<?php

namespace App\Livewire\Components;

use App\Models\Podcast;
use Livewire\Component;

class MorePodcastComponent extends Component
{
    public $podcast;
    public int $offset = 0;
    public bool $hasMorePages;
    public int $perPage = 6;
    public ?string $nextCursor = null;
    public string $moreLabel = 'More Podcast';

    public function mount()
    {
        $this->loadPodcast();
    }

    public function loadPodcast()
    {
        $podcastCursor = Podcast::latest()
            ->when($this->nextCursor, function ($query) {
                $query->cursor($this->nextCursor);
            })
            ->take($this->perPage + 1) // Fetch one more than needed to check for more pages
            ->get();

        if ($podcastCursor->count() > $this->perPage) {
            $this->podcast = $podcastCursor->take($this->perPage);
            $this->setNextCursor($podcastCursor->pop());
        } else {
            $this->podcast = $podcastCursor;
            $this->setNextCursor(null);
        }
    }


    public function loadMorePodcasts()
    {
        $this->offset += $this->perPage;
        $this->loadPodcast();
    }

    public function render()
    {
        return view('livewire.components.more-podcast-component');
    }

    protected function setNextCursor($cursor): void
{
    $this->hasMorePages = $this->podcast->count() > $this->perPage;
    if ($this->hasMorePages) {
        $this->nextCursor = $cursor->encode();
    }
}
}
