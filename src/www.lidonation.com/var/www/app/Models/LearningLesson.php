<?php

namespace App\Models;

use App\DataTransferObjects\QuizData;
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
use Illuminate\Support\Carbon;
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
        'link',
        'completed',
        'retry_at',
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

    public function completed(): Attribute
    {
        return Attribute::make(
            get: function () {
                $answerResponse = AnswerResponse::where('quiz_id', $this->quiz?->id)
                    ->where('user_id', auth()->user()->getAuthIdentifier())
                    ->first();

                if (!$answerResponse instanceof AnswerResponse) {
                    return false;
                } else {
                    return true;
                };
            },
        );
    }

    public function retryAt(): Attribute
    {
        // if the response is incorrect, return midnight of the next day of the response created_at
        return Attribute::make(
            get: function () {
                // get the latest response for lesson related by current user
                $lastResponse = AnswerResponse::where('quiz_id', $this->quiz?->id)
                    ->where('user_id', auth()->user()->getAuthIdentifier())
                    ->whereDate('created_at', "=", Carbon::now()->startOfDay())
                    ->orderBy('created_at', 'desc')
                    ->first();

                $q = AnswerResponse::where('quiz_id', $this->quiz?->id)
                    ->where('user_id', auth()->user()->getAuthIdentifier())
                    ->whereDate('created_at', "=", Carbon::now()->startOfDay())
                    ->orderBy('created_at', 'desc');

                if (!$lastResponse instanceof AnswerResponse) {
                    return null;
                }

                // if the response is correct, return null
                if ($lastResponse->correct) {
                    return null;
                }

                return Carbon::make(
                    $lastResponse
                        ->created_at
                        ->setTimezone('Africa/Nairobi')
                        ->tomorrow('Africa/Nairobi')
                        ->toAtomString()
                )->utc()->toAtomString();

//                return Carbon::make($lastResponse->created_at->timezone('Africa/Nairobi')->tomorrow())
//                    ->setTimezone('Africa/Nairobi')
//                    ->toAtomString();
            },
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
            get: function ($value) {
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

    public function firstModule() : Attribute
    {
        return Attribute::make(
            get:function (){
                $modulesCount = $this->topics->first()->learningModules()->count();

                if($modulesCount==0 || $modulesCount>1)
                {
                    return null;
                }

                return  $this->topics()->first()->learningModules()->first();
            }
        );
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
