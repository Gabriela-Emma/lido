<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Enums\ComponentThemesEnum;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class MorePostsComponent extends Component
{
    public $theme = ComponentThemesEnum::column;

    public ?Collection $posts;

    public bool $hasMorePages;

    public int $offset = 0;

    public int $perPage = 6;

    public ?string $nextCursor = null;

    public string $moreLabel = 'More Posts';

    public Category|Tag|null $taxonomy;

    protected ?object $taxInstance;

    protected string $taxPivotColumn;

    protected ?object $pivotInstance;

    public function mount(): void
    {
        if (isset($this->taxonomy)) {
            $this->moreLabel = 'More '.ucfirst($this->taxonomy->title).' Posts';
            $this->mountTaxonomy();
        } else {
            $postsCursor = Post::with(['media', 'tags'])
                ->latest('published_at')
                ->offset($this->offset)
                ->cursorPaginate($this->perPage);

            $this->setNextCursor($postsCursor);
        }
    }

    public function mountTaxonomy(): void
    {
        $this->setTaxonomyModelDetails();

        $taxonomy = $this->taxInstance::where('id', $this->taxonomy->id)->get();
        if (! $taxonomy || $taxonomy->isEmpty()) {
            return;
        }
        $postsCursor = $taxonomy
            ->map(function ($tax) {
                $taxIds = $this->pivotInstance::where([
                    $this->taxPivotColumn => $this->taxonomy->id,
                ])->pluck('model_id')->all();
                Post::withoutGlobalScope(LimitScope::class);
                $tax->cursor = Post::whereIn('id', $taxIds)
                    ->orderByDesc('published_at')
                    ->cursorPaginate($this->perPage);

                return $tax;
            })
            ->first()
            ->cursor;

        $this->setNextCursor($postsCursor);
    }

    public function placeholder(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('components.placeholder.more-posts-placeholder')->with([
            'postLoadCount' => $this->perPage,
        ]);
    }

    public function loadMorePosts(): void
    {
        if (isset($this->taxonomy)) {
            $this->moreTaxonomyPosts();
        } else {
            $this->morePosts();
        }
    }

    public function moreTaxonomyPosts(): void
    {
        $this->setTaxonomyModelDetails();

        $postsCursor = $this->taxInstance::where('id', $this->taxonomy->id)
            ->get()
            ->map(function ($tax) {
                $taxIds = $this->pivotInstance::where([
                    $this->taxPivotColumn => $this->taxonomy->id,
                ])->pluck('model_id')->all();
                Post::withoutGlobalScope(LimitScope::class);
                $tax->cursor = Post::whereIn('id', $taxIds)
                    ->orderByDesc('published_at')
                    ->cursorPaginate($this->perPage, ['*'], 'cursor', $this->nextCursor);

                return $tax;
            })
            ->first()
            ->cursor;

        $newPosts = collect($postsCursor->items());

        $this->addNewPosts($newPosts);
        $this->setNextCursor($postsCursor);
    }

    public function morePosts(): void
    {
        $postsCursor = Post::latest('published_at')
            ->cursorPaginate($this->perPage, ['*'], 'cursor', $this->nextCursor);

        $newPosts = collect($postsCursor->items())->each(fn ($p) => $p->load(['media', 'tags']));

        $this->addNewPosts($newPosts);
        $this->setNextCursor($postsCursor);
    }

    protected function addNewPosts($newPosts): void
    {
        isset($this->posts)
            ? $this->posts = $this->posts->merge($newPosts)
            : $this->posts = $newPosts;
    }

    protected function setNextCursor($cursor): void
    {
        $this->hasMorePages = $cursor->hasMorePages();
        if ($this->hasMorePages) {
            $this->nextCursor = $cursor->nextCursor()->encode();
        }
    }

    protected function setTaxonomyModelDetails(): void
    {
        switch ($this->taxonomy) {
            case $this->taxonomy instanceof Category:
                $this->taxInstance = app('App\Models\Category');
                $this->taxPivotColumn = 'category_id';
                $this->pivotInstance = app('App\Models\ModelCategory');
                break;

            case $this->taxonomy instanceof Tag:
                $this->taxInstance = app('App\Models\Tag');
                $this->taxPivotColumn = 'tag_id';
                $this->pivotInstance = app('App\Models\ModelTag');
                break;
        }
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.components.more-posts');
    }
}
