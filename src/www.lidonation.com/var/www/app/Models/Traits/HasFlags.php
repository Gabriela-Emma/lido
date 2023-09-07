<?php

namespace App\Models\Traits;

use App\Models\Flag;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasFlags
{
    public function flags(): HasMany
    {
        return $this->hasMany(Flag::class, 'model_id')->where('model_type', static::class);
    }
}
