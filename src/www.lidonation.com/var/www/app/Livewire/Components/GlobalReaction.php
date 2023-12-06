<?php

namespace App\Livewire\Components;

use App\Enums\ReactionEnum;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GlobalReaction extends Component
{
    public $post;

    public array $reactions = [
        'heart' => [
            'label' => 'heart',
            'count' => 0,
        ],
        'eye' => [
            'label' => 'eye',
            'count' => 0,
        ],
        'party_popper' => [
            'label' => 'party_popper',
            'count' => 0,
        ],
        'rocket' => [
            'label' => 'rocket',
            'count' => 0,
        ],
        'thumbs_down' => [
            'label' => 'thumbs_down',
            'count' => 0,
        ],
        'thumbs_up' => [
            'label' => 'thumbs_up',
            'count' => 0,
        ],
    ];

    protected $user;

    public function mount(Post $post): void
    {
        $post->load(['media']);

        $this->user = Auth::user();
        $this->post = $post;
    }

    public function addReaction($reactionType, $postId): void
    {
        $this->post->addLidoReaction($reactionType, $this->user);
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {

        $this->loadReactions();

        return view('livewire.components.global-reaction')
            ->with('loading', true);
    }

    public function placeholder(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('components.placeholder.global-reaction-placeholder');
    }

    protected function loadReactions(): void
    {
        $this->post->loadCount([
            'comments',
            'heart',
            'eye',
            'party_popper',
            'rocket',
            'thumbs_down',
            'thumbs_up',
        ]);

        $this->reactions = collect($this->reactions)
            ->mapWithKeys(function ($reaction, $key) {
                $prop = "{$key}_count";

                return [
                    $key => [
                        'label' => (ReactionEnum::from($reaction['label']))->value,
                        'count' => $this->post->{$prop},
                    ],
                ];
            })->toArray();
    }
}
