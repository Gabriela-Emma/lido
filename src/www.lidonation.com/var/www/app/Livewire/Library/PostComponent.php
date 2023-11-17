<?php

namespace App\Livewire\Library;

use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PostComponent extends Component
{
    public Post $post;

    public function mount(Post $post): void
    {
        $this->post = $post;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.post')
            ->title($this->post->title)
            ->withShortcodes();
    }
}
