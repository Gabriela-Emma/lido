<?php

namespace App\Models\Traits;

use App\Models\Giveaway;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasGiveaways
{
    public function giveaway(): Attribute
    {
        return Attribute::make(get: fn ($value) => $this->giveaways?->first());
    }

    public function giveaways(): MorphToMany
    {
        return $this->morphToMany(Giveaway::class, 'model', 'giveaway_model', 'model_id', 'giveaway_id')
            ->wherePivot('model_type', static::class);
    }
}
