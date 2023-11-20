<?php

namespace App\Livewire;

use App\Repositories\PostRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('LIDO Nation Pool Details')]
class LidoPoolDetails extends Component
{
    public function render(PostRepository $posts): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $post = $posts->get('about-the-pool');
        if (! $post) {
            throw new ModelNotFoundException('Post not found');
        }

        return view('livewire.lido-pool-details', compact('post'));
    }
}
