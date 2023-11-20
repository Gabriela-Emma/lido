<?php

namespace App\Livewire;

use App\Models\OnboardingContent;
use App\Models\Post;
use App\Repositories\PostRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('How to stake Ada')]
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
