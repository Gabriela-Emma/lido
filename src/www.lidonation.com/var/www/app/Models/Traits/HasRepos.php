<?php

namespace App\Models\Traits;

use App\Models\Repo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasRepos
{
    public function repos(): HasMany
    {
        return $this->hasMany(Repo::class, 'model_id')
            ->where('model_type', static::class);
    }
}
