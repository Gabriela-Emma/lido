<?php

namespace App\Livewire;

use Closure;
use App\Models\Post;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\OnboardingContent;
use Illuminate\Contracts\View\View;
use App\Repositories\PostRepository;

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
