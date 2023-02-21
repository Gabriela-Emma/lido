<?php

namespace App\Models\Traits;

use App\Models\Assessment;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasAssessments
{
    public function comments(): HasMany
    {
        return $this->assessments();
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class, 'model_id')
            ->where('model_type', static::class)
            ->whereNull('parent_id')
            ->limit(12);
    }

    public function comments_with_children(): HasMany
    {
        return $this->hasMany(Assessment::class, 'model_id')
            ->where('model_type', static::class);
    }
}
