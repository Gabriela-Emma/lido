<?php

namespace App\Models;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Taxonomy
{
    public function getUrlAttribute(): string|UrlGenerator|Application
    {
        return url("categories/{$this->slug}");
    }

    //    public function models(): MorphToMany
    //    {
    //        return $this->morphToMany(Model::class, 'model', ModelTag::class, 'category_id', 'model_id');
    //    }

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'model', ModelCategory::class, 'category_id', 'model_id')
            ->withPivot(['model_type']);
    }

    public function reviews(): MorphToMany
    {
        return $this->morphedByMany(Review::class, 'model', ModelCategory::class, 'category_id', 'model_id')
            ->withPivot(['model_type']);
    }

    public function proposals(): MorphToMany
    {
        return $this->morphedByMany(Proposal::class, 'model', ModelCategory::class, 'category_id', 'model_id')
            ->withPivot(['model_type']);
    }
}
