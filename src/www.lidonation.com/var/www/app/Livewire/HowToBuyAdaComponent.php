<?php

namespace App\Livewire;

use App\Models\OnboardingContent;
use App\Models\Post;
use App\Repositories\PostRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

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
