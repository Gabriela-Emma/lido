<?php

namespace App\Models\Traits;

use App\Models\Reward;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasRewards
{
    public function rewards(): HasMany
    {
        return $this->hasMany(Reward::class, 'model_id')->where('model_type', static::class);
    }
}
