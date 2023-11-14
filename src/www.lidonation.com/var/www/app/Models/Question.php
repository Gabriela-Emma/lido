<?php

namespace App\Models;

use App\DataTransferObjects\QuizQuestionAnswerData;
use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTranslations;
use App\Scopes\OrderByRandomScope;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\LaravelData\DataCollection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Question extends Model implements HasMedia, IHasMetaData
{
    use HasAuthor,
        HasMetaData,
        HasTimestamps,
        HasTranslations,
        InteractsWithMedia,
        SoftDeletes;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime:M d y',
        'published_at' => 'datetime:M d y',
        'answers' => DataCollection::class.':'.QuizQuestionAnswerData::class,
    ];

    public array $translatable = [
        'title',
        'content',
    ];

    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    public function responses(): HasManyThrough
    {
        return $this->hasManyThrough(AnswerResponse::class, QuestionAnswer::class);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope(new OrderByRandomScope());
    }
}
