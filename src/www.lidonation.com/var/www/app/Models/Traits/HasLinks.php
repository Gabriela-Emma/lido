<?php

namespace App\Models\Traits;

use App\Models\Link;
use App\Models\ModelLink;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasLinks
{
    public function links(): BelongsToMany
    {
        return $this->belongsToMany(Link::class, ModelLink::class, 'model_id', 'link_id')
            ->where('model_type', static::class)
            ->withPivot('model_type');
    }
}
