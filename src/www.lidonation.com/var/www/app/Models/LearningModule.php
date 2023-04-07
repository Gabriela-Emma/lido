<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningModule extends Model
{
    use HasAuthor,
        HasHero,
        HasMetaData,
        HasTranslations,
        HasTimestamps,
        SoftDeletes;

    public array $translatable = [
        'title',
        'content'
    ];

    public function length(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->topics->sum(fn ($topic) => $topic->lessons->sum('length'))
        );
    }

    public function lessonsCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->topics->sum(fn ($topic) => $topic->lessons->count())
        );
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function learningTopics(): BelongsToMany
    {
        return $this->belongsToMany(LearningTopic::class);
    }

    public function topics(): BelongsToMany
    {
        return $this->learningTopics();
    }
}
