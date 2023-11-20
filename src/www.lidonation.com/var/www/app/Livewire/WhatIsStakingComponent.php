<?php

namespace App\Livewire;

use App\Models\OnboardingContent;
use App\Models\Post;
use App\Repositories\PostRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('What is staking on Cardano')]
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
