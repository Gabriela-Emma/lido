<?php

namespace App\Livewire\Components;

use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class MoreHeadlinesComponent extends Component
{
    public ?Collection $newHeadlines;

    public bool $hasMorePages;

    public int $offset = 0;

    public int $perPage = 2;

    public ?string $nextCursor = null;

    public string $moreLabel = 'More Posts Headlines';

    public function mount(): void
    {
        $postsCursor = Post::with(['media', 'tags'])
            ->where('type', Post::class)
            ->orderByDesc('published_at')
            ->offset($this->offset)
            ->cursorPaginate($this->perPage);

        $this->hasMorePages = $postsCursor->hasMorePages();

        if ($this->hasMorePages) {
            $this->nextCursor = $postsCursor->nextCursor()->encode();
        }
    }

    public function placeholder(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('components.placeholder.more-headlines-placeholder')->with([
            'postLoadCount' => $this->perPage,
        ]);
    }

    public function loadMoreHeadlines(): void
    {
        $postsCursor = Post::where('type', Post::class)
            ->orderByDesc('published_at')
            ->cursorPaginate(
                $this->perPage,
                ['*'],
                'cursor',
                $this->nextCursor
            );

        $newPosts = collect($postsCursor->items())->each(fn ($p) => $p->load(['media', 'tags']));

        if (isset($this->newHeadlines)) {
            $this->newHeadlines = $this->newHeadlines->merge($newPosts);
        } else {
            $this->newHeadlines = $newPosts;
        }

        $this->hasMorePages = $postsCursor->hasMorePages();

        if ($this->hasMorePages) {
            $this->nextCursor = $postsCursor->nextCursor()->encode();
        }
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.components.more-headlines');
    }
}
