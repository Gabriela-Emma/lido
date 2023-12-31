<?php

namespace App\Models;

use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionAnswer extends Model implements IHasMetaData
{
    use HasAuthor,
        HasMetaData,
        HasTimestamps,
        HasTranslations,
        SoftDeletes;

    protected $appends = [
        'correct',
    ];

    public $translatable = [
        'content',
        'hint',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime:M d y',
        'published_at' => 'datetime:M d y',
    ];

    public function correct(): Attribute
    {
        return Attribute::make(get: fn () => $this?->correctness === 'correct');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(AnswerResponse::class, 'question_answer_id', 'id');
    }
}
