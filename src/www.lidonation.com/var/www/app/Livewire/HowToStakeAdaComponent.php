<?php

namespace App\Livewire;

use Closure;
use App\Models\Post;
use Livewire\Component;
use App\Models\OnboardingContent;
use Illuminate\Contracts\View\View;
use App\Repositories\PostRepository;

class HowToStakeAdaComponent extends Component
{
    public $post;

    public function __construct()
    {
        $posts = new PostRepository(new Post());
        $this->post = $posts->setModel(new OnboardingContent)->get('how-to-stake-your-ada');
    }

    public function render(): View|Closure|string
    {           
    return view('components.how-to-stake-ada')->with('post', $this->post);
    }
}
