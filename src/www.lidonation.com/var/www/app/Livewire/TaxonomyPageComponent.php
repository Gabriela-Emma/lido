<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use livewire\Component;

class TaxonomyPageComponent extends Component
{
    public $featurePost;

    public $taxonomy;

    public int $perPage = 8;

    public function mount(Request $request, Category $category, Tag $tag): void
    {
        $this->taxonomy = $category->id ? $category : $tag;
        $this->featurePost = $this->taxonomy->posts()->first();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.taxonomy')->withShortcodes();
    }
}
