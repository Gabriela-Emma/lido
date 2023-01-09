<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessor extends Model
{
    public function assessments(): BelongsToMany
    {
        return $this->belongsToMany(LegacyComment::class, 'assessment_reviews_comments_assessors', 'assessment_id', 'assessor_id');
    }

    public function assessment_reviews(): HasMany
    {
        return $this->hasMany(AssessmentReview::class);
    }
}
