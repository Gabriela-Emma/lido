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

class LearningTopic extends Model
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
            get: fn () => $this->lessons->count('length')
        );
    }

    public function learningLessons(): BelongsToMany
    {
        return $this->belongsToMany(LearningLesson::class);
    }

    public function lessons(): BelongsToMany
    {
        return $this->learningLessons();
    }
}
