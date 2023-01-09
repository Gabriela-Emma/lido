<?php

namespace App\Http\Livewire\Library;

use App\Models\Category;
use App\Models\Insight;
use App\Models\ModelCategory;
use App\Models\News;
use App\Models\Podcast;
use App\Models\Post;
use App\Models\Review;
use App\Models\Tag;
use App\Repositories\PostRepository;
use App\Scopes\LimitScope;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class LibraryComponent extends Component
{
    public ?int $cardanoStakedAddresses;

    public $reviews;
    public $tags;
    public $latestLidoMinutes;
    public $categories;
    public $newToLibrary;
    public $latestLidoMinute;

    protected function posts(): Builder
    {
        return Post::whereIn('type', [News::class, Review::class, Insight::class]);
    }

    public function mount(PostRepository $posts)
    {
        $this->reviews = $posts->setModel(new Review)->limit(3)->all();
        $this->latestLidoMinute = Podcast::where('status', 'published')->orderBy('published_at', 'DESC')->first();
        $this->latestLidoMinutes = Podcast::orderBy('published_at')->limit(5)->get();
        $this->tags = Tag::whereHas('insights')->orWhereHas('news')->orWhereHas('reviews')->get();
        $this->categories = Category::whereHas('insights')->orWhereHas('news')->orWhereHas('reviews')->get()
            ->map(function ($cat) {
                $catIds = ModelCategory::where([
                    'category_id' => $cat->id
                ])->pluck('model_id')->all();
                Post::withoutGlobalScope(LimitScope::class);
                $cat->models = Post::whereIn('id', $catIds)
                    ->limit(4)->get();
                return $cat;
            })->sortByDesc(fn($c) => $c->posts_count)->values();
        $this->postsCount = count($this->posts()->get());
        $this->newToLibrary = $this->posts()->limit($this->latestLidoMinute instanceof Podcast ? 3 : 4)
            ->get()
            ->map(fn($m) => $m->load(['media', 'tags']))
            ->all();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.library.app')->layoutData(['metaTitle' => 'Lido Library']);
    }
}
