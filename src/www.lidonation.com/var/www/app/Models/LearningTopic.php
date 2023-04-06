<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LearningTopic extends Model
{
    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(LearningLesson::class);
    }
}
