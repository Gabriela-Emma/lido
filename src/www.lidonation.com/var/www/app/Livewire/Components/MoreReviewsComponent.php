<?php

namespace App\Livewire\Components;

use App\Models\Post;
use App\Models\Review;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class MoreReviewsComponent extends Component
{
    public ?Collection $moreReviews;

    public bool $hasMorePages;

    public int $offset = 0;

    public int $perPage = 2;

    public ?string $nextCursor = null;

    public string $moreLabel = 'More Recent Reviews';

    public function mount(): void
    {
        $postsCursor = Post::with(['media', 'tags'])
            ->where('type', Review::class)
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
        return view('components.placeholder.more-reviews-placeholder')->with([
            'postLoadCount' => $this->perPage,
        ]);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.components.more-reviews');
    }

    public function loadMorePosts(): void
    {
        $postsCursor = Post::where('type', Review::class)
            ->orderByDesc('published_at')
            ->cursorPaginate(
                $this->perPage,
                ['*'],
                'cursor',
                $this->nextCursor
            );

        $newPosts = collect($postsCursor->items())->each(fn ($p) => $p->load(['media', 'tags']));

        if (isset($this->moreReviews)) {
            $this->moreReviews = $this->moreReviews->merge($newPosts);
        } else {
            $this->moreReviews = $newPosts;
        }

        $this->hasMorePages = $postsCursor->hasMorePages();

        if ($this->hasMorePages) {
            $this->nextCursor = $postsCursor->nextCursor()->encode();
        }
    }
}
