<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasLocaleUrl;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasSlug;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningModule extends Model
{
    use HasAuthor,
        HasHero,
        HasLocaleUrl,
        HasMetaData,
        HasSlug,
        HasTimestamps,
        HasTranslations,
        SoftDeletes;

    protected $casts = [
        //        'topics' => DataCollection::class.':'.LearningTopicData::class,
    ];

    public $appends = [
        'length',
        'lessons_count',
        'link',
    ];

    public array $translatable = [
        'title',
        'content',
    ];

    public function length(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->learning_topics?->sum(fn ($topic) => $topic->lessons()->sum('length'))
        );
    }

    public function lessonsCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->learning_topics?->sum(fn ($topic) => $topic->learningLessons()?->count())
        );
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getUrlGroup(): string
    {
        return 'earn/learn/modules';
    }

    public function learningTopics(): BelongsToMany
    {
        return $this->belongsToMany(LearningTopic::class);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
