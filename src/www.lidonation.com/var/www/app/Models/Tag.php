<?php

namespace App\Models;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;

class Tag extends Taxonomy
{
    public $append = [
        'models',
    ];

    public function getUrlAttribute(): string|UrlGenerator|Application
    {
        return url("tags/{$this->slug}");
    }

    public function funds(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(PropFundosal::class, ModelTag::class, 'tag_id', 'model_id')
            ->withPivot(['model_type']);
    }

    public function proposals(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Proposal::class, ModelTag::class, 'tag_id', 'model_id')
            ->withPivot(['model_type']);
    }

    public function insights(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Insight::class, ModelTag::class, 'tag_id', 'model_id')
            ->withPivot(['model_type']);
    }

    public function news(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(News::class, ModelTag::class, 'tag_id', 'model_id')
            ->withPivot(['model_type']);
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Review::class, ModelTag::class, 'tag_id', 'model_id')
            ->withPivot(['model_type']);
    }

    //    public function models(): MorphToMany
    //    {
    //        return $this->morphToMany(Model::class, 'model', ModelTag::class, 'tag_id', 'model_id');
    //    }
}
