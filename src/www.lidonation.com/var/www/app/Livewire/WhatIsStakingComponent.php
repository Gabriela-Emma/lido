<?php

namespace App\Livewire;

use Closure;
use App\Models\Post;
use Livewire\Component;
use App\Models\OnboardingContent;
use Illuminate\Contracts\View\View;
use App\Repositories\PostRepository;

class WhatIsStakingComponent extends Component
{
    public $post;

    public function __construct()
    {
        $posts = new PostRepository(new Post());
        $this->post = $posts->setModel(new OnboardingContent)->get('what-is-the-point-of-buy-ada-and-staking-in-cardano');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.what-is-staking')->with('post', $this->post);
    }
}
