<?php

namespace App\Models;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Taxonomy
{
    public $append = [];

    public function getUrlAttribute(): string|UrlGenerator|Application
    {
        return url("tags/{$this->slug}");
    }

    public function funds(): BelongsToMany
    {
        return $this->belongsToMany(PropFundosal::class, ModelTag::class, 'tag_id', 'model_id')
            ->withPivot(['model_type']);
    }

    public function proposals(): BelongsToMany
    {
        return $this->belongsToMany(Proposal::class, ModelTag::class, 'tag_id', 'model_id')
            ->withPivot(['model_type']);
    }

    public function insights(): BelongsToMany
    {
        return $this->belongsToMany(Insight::class, ModelTag::class, 'tag_id', 'model_id')
            ->withPivot(['model_type']);
    }
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, ModelTag::class, 'tag_id', 'model_id')
            ->withPivot(['model_type']);
    }

    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany(Review::class, ModelTag::class, 'tag_id', 'model_id')
            ->withPivot(['model_type']);
    }
}
