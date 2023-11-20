<?php

namespace App\Livewire;

use App\Models\OnboardingContent;
use App\Models\Post;
use App\Repositories\PostRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('What is Cardano')]
class WhatIsCardanoComponent extends Component
{
    public $post;

    public function __construct()
    {
        $posts = new PostRepository(new Post());
        $this->post = $posts->setModel(new OnboardingContent)->get('what-is-cardano-and-how-does-it-use-the-blockchain');
    }

    public function render(): View|Closure|string
    {
        return view('components.what-is-cardano')->with('post', $this->post);
    }
}
