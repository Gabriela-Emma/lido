<?php

namespace App\Models;

use App\DataTransferObjects\LearningTopicData;
use App\DataTransferObjects\QuizData;
use App\DataTransferObjects\QuizQuestionAnswerData;
use App\DataTransferObjects\QuizQuestionData;
use App\Http\Traits\HasHashIds;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasHero;
use App\Models\Traits\HashIdModel;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasModel;
use App\Models\Traits\HasRewards;
use App\Models\Traits\HasTranslations;
use App\Scopes\OrderByOrderScope;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtownsend\ReadTime\ReadTime;
use Spatie\LaravelData\DataCollection;

class LearningLesson extends Model
{
    use HasAuthor,
        HasHero,
        HasRewards,
        HasHashIds,
        HashIdModel,
        HasMetaData,
        HasModel,
        HasTranslations,
        HasTimestamps,
        SoftDeletes;

    protected $hidden = ['id'];

    protected $appends = [
        'hash',
        'link'
    ];

    protected $casts = [
        'quiz' => QuizData::class,
        'quizzes' => DataCollection::class . ':' . QuizQuestionData::class
    ];

    public array $translatable = [
        'title',
        'content'
    ];

    public function slug(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->hash,
        );
    }

    public function quiz(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->quizzes()?->first(),
        );
    }

    public function length(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                if ($value) {
                    return $value;
                }
                $parts = (new ReadTime($this->model?->content ?? ''))
                    ->omitSeconds(false)
                    ->timeOnly()
                    ->toArray();
                return ($parts['minutes'] * 60) + $parts['seconds'];
            },
        );
    }

    public function getUrlGroup(): string
    {
        return 'earn/learn/lessons';
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(LearningTopic::class);
    }

    // @todo not sure if this is the best way to do this or if it's even possible
    public function modules()
    {
        return $this->belongsToManyThrough(LearningModule::class, LearningTopic::class);
    }

    public function quizzes(): MorphToMany
    {
        return $this->morphToMany(Quiz::class, 'model', 'model_quiz', 'model_id', 'quiz_id')
            ->wherePivot('model_type', static::class);
    }

//    public function quiz()
//    {
//        return $this->quizzes()->first();
//    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new PublishedScope);
        static::addGlobalScope(new OrderByOrderScope);
    }
}
