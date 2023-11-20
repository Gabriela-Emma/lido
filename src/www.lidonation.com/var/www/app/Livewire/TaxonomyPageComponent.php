<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use livewire\Component;

class TaxonomyPageComponent extends Component
{
    public $category;

    public $tag;

    public $postsByCategory;

    public $postsByTag;

    public $taxonomy;

    public int $perPage = 8;

    public function mount(Request $request, Category $category, Tag $tag): void
    {
        if (Route::currentRouteNamed('category')) {
            $this->postsByCategory = $this->category->load(['posts', 'insights']);
            $this->taxonomy = $this->postsByCategory;
        } else {
            $this->postsByTag = $this->tag->load(['posts', 'insights']);
            $this->taxonomy = $this->postsByTag;
        }
    }

    public function render(): Factory|View|Application
    {
        if (Route::currentRouteNamed('category')) {
            return view('livewire.category')->withShortcodes();
        }

        return view('livewire.tag')->title($this->taxonomy->title)->withShortcodes();
    }
}
