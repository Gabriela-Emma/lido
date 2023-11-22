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

    public array $reactions = [
        'heart',
        'eye',
        'party_popper',
        'rocket',
        'thumbs_down',
        'thumbs_up',
    ];

    public function mount(Post $post): void
    {
        $post->load(['media'])->loadCount([
            'comments',
            'heart',
            'eye',
            'party_popper',
            'rocket',
            'thumbs_down',
            'thumbs_up',
        ]);

        $this->reactions = collect($this->reactions)->mapWithKeys(function ($reaction) use ($post) {
            $prop = "{$reaction}_count";
            return [$reaction => $post->{$prop}];
        })->toArray();

        $this->post = $post;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.post')
            ->title($this->post->title)
            ->withShortcodes();
    }
}
