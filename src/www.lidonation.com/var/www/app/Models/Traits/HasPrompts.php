<?php

namespace App\Models\Traits;

use App\Models\Prompt;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasPrompts
{
    public function questions(): HasMany
    {
        return $this->hasMany(Prompt::class, 'model_id')
            ->where('model_type', static::class)
            ->whereNull('parent_id')
            ->limit(12);
    }
}
