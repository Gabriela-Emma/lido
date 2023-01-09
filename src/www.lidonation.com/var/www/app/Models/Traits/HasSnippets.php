<?php

namespace App\Models\Traits;

use App\Models\ModelSnippet;
use App\Models\Snippet;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasSnippets
{
    public function snippets(): BelongsToMany
    {
        return $this->belongsToMany(Snippet::class, ModelSnippet::class, 'model_id', 'snippet_id')
            ->where('model_type', static::class)
            ->orderBy('order')
            ->withPivot('model_type');
    }
}
