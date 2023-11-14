<?php

namespace App\Models\CatalystExplorer;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessor extends Model
{
    use HasFactory;

    public function assessments(): BelongsToMany
    {
        return $this->belongsToMany(Assessment::class, 'assessment_reviews_comments_assessors', 'assessment_id', 'assessor_id');
    }

    public function assessment_reviews(): HasMany
    {
        return $this->hasMany(AssessmentReview::class);
    }
}
