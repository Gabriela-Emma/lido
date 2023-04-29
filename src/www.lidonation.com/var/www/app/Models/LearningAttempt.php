<?php

namespace App\Models;

use App\Enums\LearningAttemptStatuses;
use App\Models\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningAttempt extends Model
{
    use HasAuthor, HasTimestamps, SoftDeletes;

    protected $casts = [
        'updated_at' => 'datetime:M d y',
        'published_at' => 'datetime:M d y',
        'status' => LearningAttemptStatuses::class,
    ];

    protected $fillable = [
        'user_id',

        'learning_module_id',
        'learning_topic_id',
        'learning_lesson_id',

        'quiz_id',
        'question_id',
        'question_answer_id',
        'answer_response_id',

        'status',
    ];

    public function learningModule(): BelongsTo
    {
        return $this->belongsTo(LearningModule::class, 'learning_module_id');
    }

    public function learningTopic(): BelongsTo
    {
        return $this->belongsTo(LearningTopic::class, 'learning_topic_id');
    }

    public function learning(): BelongsTo
    {
        return $this->belongsTo(LearningLesson::class, 'learning_lesson_id', 'id', 'learning');
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function response(): BelongsTo
    {
        return $this->belongsTo(AnswerResponse::class, 'answer_response_id', 'id', 'response');
    }
}
