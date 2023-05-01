<?php

namespace App\Models;

use App\DataTransferObjects\LearningTopicData;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasLocaleUrl;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTranslations;
use App\Scopes\OrderByOrderScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\LaravelData\DataCollection;

class LearningTopic extends Model
{
    use HasAuthor,
        HasHero,
        HasLocaleUrl,
        HasMetaData,
        HasTranslations,
        HasTimestamps,
        SoftDeletes;

    protected $casts = [
        'lessons' => DataCollection::class.':'.LearningTopicData::class,
    ];

    public $appends = [
        'length',
        'link',
    ];

    public array $translatable = [
        'title',
        'content',
    ];

    public function length(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->lessons?->count('length')
        );
    }

    public function getUrlGroup(): string
    {
        return 'earn/learn/topics';
    }

    public function learningModules(): BelongsToMany
    {
        return $this->belongsToMany(LearningModule::class);
    }

    public function learningLessons(): BelongsToMany
    {
        return $this->belongsToMany(LearningLesson::class);
    }

    public function lessons(): BelongsToMany
    {
        return $this->learningLessons();
    }

    public function topicAvailable(): Attribute
    {
        return Attribute::make(
            get: function () {
                $topicsBefore = LearningTopic::where('order', '<', $this->order)->get();
                $incompleteLessons = $topicsBefore->flatMap(function ($topic) {
                    return $topic->lessons()->get()->reject(function ($lesson) {
                        return $lesson->completed;
                    });
                });

                return $incompleteLessons->isEmpty();
            }
        );
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new OrderByOrderScope);
    }
}
