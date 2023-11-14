<?php

namespace App\Models\CatalystExplorer;

use App\Models\Model;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AssessmentReview extends Model
{
    use HasTranslations;

    public $translatable = [
        'qa_rationale',
    ];

    public function assessments(): BelongsToMany
    {
        return $this->belongsToMany(Assessment::class, 'assessment_reviews_comments_assessors', 'assessment_review_id', 'assessment_id');
    }

    public function assessor(): BelongsTo
    {
        return $this->belongsTo(Assessor::class, 'assessor_id');
    }
}
