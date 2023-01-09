<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentReviewsCommentsAssessors extends Model
{
    public $timestamps = false;

    public function assessor(): BelongsTo
    {
        return $this->belongsTo(Assessor::class);
    }

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(LegacyComment::class, 'assessment_id');
    }

    public function assessment_review(): BelongsTo
    {
        return $this->belongsTo(AssessmentReview::class);
    }
}
