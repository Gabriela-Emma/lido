<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Post;
use Livewire\Attributes\Lazy;

#[Lazy]
class GlobalReaction extends Component
{
    public $reactions;
    public $post;

    public function mount($post)
    {
        $this->post = $post;
        $this->reactions = $this->post->lido_reactions()->get()->toArray();
    }

    public function addReaction($reactionType)
    {
        $this->post->lido_reactions()->create(['type' => $reactionType]);
        $this->reactions = $this->post->lido_reactions()->get();
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
