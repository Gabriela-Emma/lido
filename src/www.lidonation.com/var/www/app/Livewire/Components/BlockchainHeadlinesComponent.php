<?php

namespace App\Livewire\Components;

use App\Models\News;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Scopes\LimitScope;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class BlockchainHeadlinesComponent extends Component
{
    public $quickNews;

    public int $limit = 3;

    public function mount(PostRepository $postRepository): void
    {
        Post::withoutGlobalScope(LimitScope::class);
        $this->quickNews = Post::where('type', News::class)
            ->orderByDesc('published_at')
            ->limit($this->limit)
            ->get()
            ->each(fn ($p) => $p->load(['media', 'tags']))
            ->collect();
    }

    public function placeholder(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('components.placeholder.headlines-placeholder')->with([
            'postLoadCount' => $this->limit,
        ]);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.components.blockchain-headlines');
    }
}
