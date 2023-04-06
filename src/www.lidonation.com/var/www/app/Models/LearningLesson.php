<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LearningLesson extends Model
{
    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(LearningTopic::class);
    }

    // @todo not sure if this is the best way to do this or if it's even possible
    public function modules()
    {
        return $this->belongsToManyThrough(LearningModule::class, LearningTopic::class);
    }
}
