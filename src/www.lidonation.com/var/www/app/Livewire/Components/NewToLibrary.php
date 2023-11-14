<?php

namespace App\Livewire\Components;

use App\Models\Podcast;
use App\Models\Post;
use App\Scopes\LimitScope;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Jenssegers\Agent\Agent;
use Livewire\Component;

class NewToLibrary extends Component
{
    public ?Podcast $latestLidoMinute;

    public ?array $newToLibrary;

    public ?bool $showPodcast = false;

    public $featurePostsCount = 2;

    public ?Collection $postsArchive = null;

    public function mount(): void
    {
        $this->latestLidoMinute = Podcast::where('status', 'published')->orderBy('published_at', 'DESC')->first();
        if (isset($this->latestLidoMinute)) {
            $this->showPodcast = true;
        } else {
            $this->featurePostsCount++;
        }
        Post::withoutGlobalScope(LimitScope::class);
        $this->newToLibrary = Post::orderBy('published_at', 'DESC')
            ->limit($this->featurePostsCount)->get()
            ->each(fn ($p) => $p->load(['media', 'tags']))
            ->all();
    }

    public function togglePodcast()
    {
        $this->showPodcast = !$this->showPodcast;
        $this->featurePostsCount=$this->featurePostsCount+1;

        $this->newToLibrary=null;
        Post::withoutGlobalScope(LimitScope::class);
        $this->newToLibrary = Post::orderBy('published_at', 'DESC')
            ->limit($this->featurePostsCount)->get()
            ->each(fn ($p) => $p->load(['media', 'tags']))
            ->all();
    }

    public function placeholder(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $agent = new Agent();
        if ($agent->isTablet()) {
            $initialPostsCount = 2;
        } else {
            $initialPostsCount = 2;
        }

        return view('components.placeholder.new-to-library-placeholder')->with([
            'postLoadCount' => $initialPostsCount,
        ]);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.components.new-to-library');
    }
}
