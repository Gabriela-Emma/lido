<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Models\Podcast;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Livewire\Component;

class MorePodcastComponent extends Component
{
    public ?Collection $podcasts;

    public bool $hasMorePages;

    public int $offset = 0;

    public int $perPage = 6;

    public ?string $nextCursor = null;

    public string $moreLabel = 'More Podcast';

    public bool $showInitial = true;

    public function mount(): void
    {
        $this->podcasts = collect([]);
        if ($this->showInitial) {
            $this->loadPodcast();
        }
    }

    public function loadPodcast(): void
    {
        $podcastCursor = Podcast::latest()
            ->when($this->nextCursor, function ($query) {
                $query->cursorPaginate($this->perPage, ['*'], 'cursor', $this->nextCursor);
            })
            ->offset($this->offset)
            ->cursorPaginate($this->perPage);

        $this->addNewPodcasts(collect($podcastCursor->items()));
        $this->setNextCursor($podcastCursor);
    }

    protected function addNewPodcasts($newPosts): void
    {
        isset($this->podcasts)
            ? $this->podcasts = $this->podcasts->merge($newPosts)
            : $this->podcasts = $newPosts;
    }

    protected function setNextCursor($cursor): void
    {
        $this->hasMorePages = $cursor->hasMorePages();
        if ($this->hasMorePages) {
            $this->nextCursor = $cursor->nextCursor()->encode();
        }
    }

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.components.more-podcast-component');
    }
}
