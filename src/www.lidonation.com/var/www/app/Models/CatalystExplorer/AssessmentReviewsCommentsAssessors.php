<?php

namespace App\Models\CatalystExplorer;

use App\Models\Model;
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
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }

    public function assessment_review(): BelongsTo
    {
        return $this->belongsTo(AssessmentReview::class);
    }
}
