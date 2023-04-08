<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasLocaleUrl;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningLesson extends Model
{
    use HasAuthor,
        HasHero,
        HasLocaleUrl,
        HasMetaData,
        HasTranslations,
        HasTimestamps,
        SoftDeletes;

    public $appends = [
        'link',
    ];

    public array $translatable = [
        'title',
        'content'
    ];

    public function getUrlGroup(): string
    {
        return 'earn/learn/modules/lessons';
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
}