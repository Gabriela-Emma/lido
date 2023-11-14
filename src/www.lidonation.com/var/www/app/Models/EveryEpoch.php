<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasGiveaways;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EveryEpoch extends Model implements HasMedia
{
    use HasAuthor,
        HasFactory,
        HasGiveaways,
        HasMetaData,
        HasTimestamps,
        HasTranslations,
        InteractsWithMedia,
        SoftDeletes;

    protected $table = 'every_epochs';

    public $translatable = [
        'title',
        'content',
    ];

    public function giveaway(): Attribute
    {
        return Attribute::make(get: fn ($value) => $this->giveaways?->first() ?? $this->quizzes?->first()?->giveaway);
    }

    public function quizzes(): MorphToMany
    {
        return $this->morphToMany(Quiz::class, 'model', 'model_quiz', 'model_id', 'quiz_id')
            ->wherePivot('model_type', static::class);
    }
}
