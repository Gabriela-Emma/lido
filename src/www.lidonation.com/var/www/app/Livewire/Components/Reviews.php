<?php

namespace App\Livewire\Components;

use App\Models\Post;
use App\Models\Review;
use App\Scopes\LimitScope;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Reviews extends Component
{
    public $reviews;

    public int $limit = 1;

    public function mount(): void
    {
        Post::withoutGlobalScope(LimitScope::class);
        $this->reviews = Post::where('type', Review::class)
            ->orderByDesc('published_at')
            ->limit($this->limit)
            ->get()
            ->each(fn ($p) => $p->load(['media', 'tags']))
            ->collect();
    }

    public function placeholder(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('components.placeholder.reviews-placeholder')->with([
            'postLoadCount' => $this->limit,
        ]);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.components.reviews');
    }
}
