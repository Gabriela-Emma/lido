<?php

namespace App\Livewire;

use Closure;
use App\Models\Post;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\OnboardingContent;
use Illuminate\Contracts\View\View;
use App\Repositories\PostRepository;

#[Title('How to buy Ada')]
class HowToBuyAdaComponent extends Component
{
    public $post;

    public function __construct()
    {
        $posts = new PostRepository(new Post());
        $this->post = $posts->setModel(new OnboardingContent)->get('how-do-i-buy-ada');
    }

    public function render(): View|Closure|string
    {
    return view('components.how-to-buy-ada')->with('post', $this->post);
    }
}
