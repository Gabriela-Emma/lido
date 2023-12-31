<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Tag;
use App\Repositories\PostRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Blockchain & Cardano Content Library')]
class LibraryComponent extends Component
{
    public $tags;

    public $categories;

    public function mount(PostRepository $posts): void
    {
        $this->tags = Tag::whereHas('posts')->get();
        $this->categories = Category::whereHas('posts')->get();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.library');
    }
}
