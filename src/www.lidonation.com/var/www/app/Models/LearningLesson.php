<?php

namespace App\Models;

use App\Http\Traits\HasHashIds;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasHero;
use App\Models\Traits\HashIdModel;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasModel;
use App\Models\Traits\HasTranslations;
use App\Scopes\OrderByOrderScope;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningLesson extends Model
{
    use HasAuthor,
        HasHero,
        HasHashIds,
        HashIdModel,
        HasMetaData,
        HasModel,
        HasTranslations,
        HasTimestamps,
        SoftDeletes;

    protected $hidden = ['id'];

    protected $appends = [
        'link', 'hash'
    ];

    public array $translatable = [
        'title',
        'content'
    ];

    public function slug(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hash,
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
