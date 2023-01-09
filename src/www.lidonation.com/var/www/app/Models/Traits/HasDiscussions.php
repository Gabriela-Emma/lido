<?php

namespace App\Models\Traits;

use App\Models\Discussion;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasDiscussions
{
    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class, 'model_id')
            ->where('model_type', static::class)
            ->withCount(['ratings'])
            ->withAvg('ratings', 'rating');
    }
}
