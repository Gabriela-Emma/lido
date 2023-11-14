<?php

namespace App\Livewire\ContributeContent;

use App\Models\Meta;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Idea extends Component
{
    public int $postId;

    public int $votes;

    public bool $voted = false;

    public Post $post;

    public function upVote()
    {
        $vote = Meta::where([
            'key' => 'votes',
            'model_id' => $this->postId,
            'model_type' => Post::class,
        ])->first();
        if ($vote) {
            $vote->content = (int) $vote->content + 1;
        } else {
            $vote = new Meta;
            $vote->key = 'votes';
            $vote->model_id = $this->postId;
            $vote->model_type = Post::class;
            $vote->content = 1;
        }
        $vote->save();
        $this->voted = true;
        $this->votes = $vote->content;
    }

    public function claim()
    {
        $this->emitUp('ideaClaimed', $this->postId);
    }

    public function mount(Post $post)
    {
        $this->post = Post::with('metas')->find($this->postId);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.contribute-content.idea');
    }
}
