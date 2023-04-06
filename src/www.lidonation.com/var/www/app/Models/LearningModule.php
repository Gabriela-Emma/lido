<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LearningModule extends Model
{
    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(LearningTopic::class);
    }
}
