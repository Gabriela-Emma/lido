<?php

namespace App\Livewire\Components;

use App\Enums\ReactionEnum;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GlobalReaction extends Component
{
    public $post;

    public array $reactions = [
        'heart',
        'eye',
        'party_popper',
        'rocket',
        'thumbs_down',
        'thumbs_up',
    ];

    protected $user;

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

        $this->user = Auth::user();
        $this->post = $post;
        $this->reactions = collect($this->reactions)->mapWithKeys(function ($reaction) use ($post) {
            $prop = "{$reaction}_count";
            return [ (ReactionEnum::from($reaction))->value => $post->{$prop}];
        })->toArray();
    }

    public function addReaction($reactionType, $postId)
    {
        $this->post->addLidoReaction($reactionType, $this->user);
    }

    public function render()
    {
        return view('livewire.components.global-reaction')
            ->with('loading', true);
    }

    public function placeholder()
    {
        return view('components.placeholder.global-reaction-placeholder');
    }
}
