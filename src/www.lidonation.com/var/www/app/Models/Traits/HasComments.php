<?php

namespace App\Models\Traits;

use App\Models\LegacyComment;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasComments
{
    public function comments(): HasMany
    {
        return $this->hasMany(LegacyComment::class, 'model_id')
            ->where('model_type', static::class)
            ->whereNull('parent_id')
            ->limit(12);
    }

    public function comments_with_children(): HasMany
    {
        return $this->hasMany(LegacyComment::class, 'model_id')
            ->where('model_type', static::class);
    }
}
