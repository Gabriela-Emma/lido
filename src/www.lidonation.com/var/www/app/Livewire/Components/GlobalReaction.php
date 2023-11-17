<?php

namespace App\Livewire\Components;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class GlobalReaction extends Component
{
    public $reactions;

    public $post;

    protected $user;

    public function mount(Post $post)
    {
        $this->user = Auth::user();
        $this->post = $post;
        $this->reactions = $this->post->lido_reactions()->first();
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
