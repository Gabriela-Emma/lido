<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Insight;
use App\Models\ModelCategory;
use App\Models\News;
use App\Models\Post;
use App\Models\Review;
use App\Models\Tag;
use App\Repositories\PostRepository;
use App\Scopes\LimitScope;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LibraryComponent extends Component
{
    public ?int $cardanoStakedAddresses;

    public $reviews;

    public $tags;

    public int $postsCount;

    public $latestLidoMinutes;

    public $categories;

    protected function posts(): Post
    {
        return Post::whereIn('type', [News::class, Review::class, Insight::class]);
    }

    public function mount(PostRepository $posts): void
    {
        $this->tags = Tag::whereHas('insights')
            ->orWhereHas('news')
            ->orWhereHas('reviews')
            ->get();

        $this->categories = Category::whereHas('insights')->orWhereHas('news')->orWhereHas('reviews')->get()
            ->map(function ($cat) {
                $catIds = ModelCategory::where([
                    'category_id' => $cat->id,
                ])->pluck('model_id')->all();
                Post::withoutGlobalScope(LimitScope::class);
                $cat->models = Post::whereIn('id', $catIds)
                    ->limit(4)->get();

                return $cat;
            })->sortByDesc(fn ($c) => $c->posts_count)->values();

        $this->postsCount = 0;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.library');
    }
}
