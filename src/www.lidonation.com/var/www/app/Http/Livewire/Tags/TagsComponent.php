<?php

namespace App\Http\Livewire\Tags;

use App\Models\Insight;
use App\Models\News;
use App\Models\Podcast;
use App\Models\Post;
use App\Models\Review;
use App\Models\Tag;
use App\Repositories\PostRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class TagsComponent extends Component
{
    public ?int $cardanoStakedAddresses;

    public $tags;

    public $latestLidoMinutes;

    public $newToLibrary;

    public $latestLidoMinute;

    protected function posts(): Builder
    {
        return Post::whereIn('type', [News::class, Review::class, Insight::class]);
    }

    public function mount(PostRepository $posts)
    {
        $this->latestLidoMinute = Podcast::where('status', 'published')->orderBy('published_at', 'DESC')->first();
        $this->latestLidoMinutes = Podcast::orderBy('published_at')->limit(5)->get();
        $this->tags = Tag::whereHas('insights')->orWhereHas('news')->orWhereHas('reviews')->get();
        $this->postsCount = count($this->posts()->get());
        $this->newToLibrary = $this->posts()->limit($this->latestLidoMinute instanceof Podcast ? 3 : 4)
            ->get()
            ->map(fn ($m) => $m->load(['media', 'tags']))
            ->all();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.tags.app');
    }
}
