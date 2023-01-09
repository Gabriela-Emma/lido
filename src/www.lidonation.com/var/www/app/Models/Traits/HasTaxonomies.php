<?php

namespace App\Models\Traits;

use App\Models\Category;
use App\Models\ModelCategory;
use App\Models\ModelTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasTaxonomies
{
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, ModelCategory::class, 'model_id', 'category_id')
            ->where('model_type', static::class)
            ->withPivot('model_type');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, ModelTag::class, 'model_id', 'tag_id')
            ->where('model_type', static::class)
            ->withPivot('model_type');
    }
}
