<?php

namespace App\Models;

use App\DataTransferObjects\LearningTopicData;
use App\DataTransferObjects\QuizQuestionData;
use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasGiveaways;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\LaravelData\DataCollection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Quiz extends Model implements HasMedia, IHasMetaData
{
    use HasAuthor,
        HasHero,
        HasMetaData,
        HasTimestamps,
        HasTranslations,
        HasGiveaways,
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
        'questions' => DataCollection::class . ':' . QuizQuestionData::class,
    ];

    public array $translatable = [
        'title',
        'content',
    ];

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class);
    }

//    public function giveaways(): MorphToMany
//    {
//        return $this->morphToMany(Giveaway::class, 'giveaways', 'giveaway_model', 'model_id', 'giveaway_id')
//            ->wherePivot('type', static::class);
//    }

    public function models(): MorphToMany
    {
        return $this->morphedByMany(Model::class, 'model', 'model_quiz', 'quiz_id', 'model_id');
    }

    public function everyEpochs(): MorphToMany
    {
        return $this->morphedByMany(EveryEpoch::class, 'model', 'model_quiz', 'quiz_id', 'model_id');
    }

    public function lessons(): MorphToMany
    {
        return $this->morphedByMany(LearningLesson::class, 'model', 'model_quiz', 'quiz_id', 'model_id');
    }


    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'model', 'model_quiz', 'quiz_id', 'model_id');
    }
}
