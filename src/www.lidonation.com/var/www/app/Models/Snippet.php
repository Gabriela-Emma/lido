<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTranslations;
use App\Scopes\PublishedScope;
use DateTime;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Snippet extends Model implements HasMedia, Interfaces\IHasMetaData
{
    use HasFactory,
        HasAuthor,
        HasMetaData,
        HasTimestamps,
        InteractsWithMedia,
        SoftDeletes,
        HasHero,
        HasTranslations;

    protected $with = ['media'];

    public int|DateTime|null $cacheFor = 10800;

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     */
    protected static bool $flushCacheOnUpdate = true;

    public array $translatable = [
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public array $translatableExcludedFromGeneration = [];

    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new PublishedScope);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(1024)
            ->height(512)
            ->withResponsiveImages()
            ->crop(Manipulations::CROP_TOP, 1024, 512)
            ->performOnCollections('hero');
    }
}
