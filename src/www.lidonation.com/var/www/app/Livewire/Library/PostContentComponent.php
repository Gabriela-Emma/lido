<?php

namespace App\Livewire\Library;

use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PostContentComponent extends Component
{
    public Post $post;

    public string $pageLocale;

    public function mount(): void
    {
        $this->pageLocale = app()->getLocale();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.library.post-content')->withShortcodes();
    }
}
