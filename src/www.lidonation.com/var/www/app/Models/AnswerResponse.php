<?php

namespace App\Models;

use App\DataTransferObjects\QuizData;
use App\DataTransferObjects\QuizQuestionAnswerData;
use App\DataTransferObjects\QuizQuestionData;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasMetaData;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnswerResponse extends Model
{
    use HasAuthor,
        HasMetaData,
        HasTimestamps,
        SoftDeletes;

    protected $with = [
        'answer'
    ];

    protected $appends = [
        'correct'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime:M d y',
        'published_at' => 'datetime:M d y',
        'question' => QuizQuestionData::class,
        'quiz' => QuizData::class,
        'answer' => QuizQuestionAnswerData::class,
    ];

    protected $hidden = [
        'deleted_at', 'updated_at', 'status',
    ];

    public function correct(): Attribute
    {
        return Attribute::make(get: fn() => $this?->answer?->correctness === 'correct');
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(QuestionAnswer::class, 'question_answer_id');
    }
}
