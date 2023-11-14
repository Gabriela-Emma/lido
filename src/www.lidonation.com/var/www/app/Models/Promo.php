<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasTranslations;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Promo extends Model implements HasMedia
{
    use HasAuthor,
        HasHero,
        HasTranslations,
        InteractsWithMedia;

    public $translatable = [
        'title',
        'content',
    ];
    protected $includes = [
        'media',
    ];

    public function token(): MorphTo
    {
        return $this->morphTo('token', 'token_type', 'token_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(480)
            ->height(480)
            ->performOnCollections('hero');

        $this->addMediaConversion('preview')
            ->width(640)
            ->height(640)
            ->performOnCollections('hero');

        $this->addMediaConversion('full')
            ->width(1920)
            ->height(1920)
            ->performOnCollections('hero');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope(new PublishedScope);
    }
}
