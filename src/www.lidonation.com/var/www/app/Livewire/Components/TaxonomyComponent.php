<?php

namespace App\Livewire\Components;

use App\Enums\ComponentThemesEnum;
use App\Models\Category;
use App\Models\Insight;
use App\Models\ModelCategory;
use App\Models\ModelTag;
use App\Models\Post;
use App\Models\Review;
use App\Models\Tag;
use App\Scopes\LimitScope;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class TaxonomyComponent extends Component
{
    public $theme = ComponentThemesEnum::column;

    public ?Collection $posts;

    public int $perPage = 6;

    public int $offset = 0;

    public Category|Tag $taxonomy;

    public string $taxType;

    public function mount(): void
    {
        switch ($this->taxonomy) {
            case $this->taxonomy instanceof Category:
                $taxonomyInstance = app(Category::class);
                $taxPivotColumn = 'category_id';
                $pivotInstance = app(ModelCategory::class);
                $this->setPosts($taxonomyInstance, $taxPivotColumn, $pivotInstance);
                break;

            case $this->taxonomy instanceof Tag:
                $taxonomyInstance = app(Tag::class);
                $taxPivotColumn = 'tag_id';
                $pivotInstance = app(ModelTag::class);
                $this->setPosts($taxonomyInstance, $taxPivotColumn, $pivotInstance);
                break;
        }
    }

    public function placeholder(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('components.placeholder.taxonomy-placeholder')->with([
            'postLoadCount' => $this->perPage,
        ]);
    }

    public function setPosts($taxInstance, $taxPivotColumn, $pivotInstance): void
    {
        Post::withoutGlobalScope(LimitScope::class);
        $this->posts = Post::with(['media'])
            ->whereRelation('categories', 'slug', 'news-and-interviews')
            ->orderByDesc('published_at')
            ->limit($this->perPage)
            ->offset($this->offset)
            ->get();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.components.taxonomy');
    }
}
