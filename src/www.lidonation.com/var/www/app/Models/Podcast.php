<?php

namespace App\Models;

use App\Models\Interfaces\HasLink;
use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasLinks;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTranslations;
use App\Models\Traits\MintsNfts;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Podcast extends Model implements HasLink, IHasMetaData, HasMedia
{
    use HasAuthor,
        HasMetaData,
        HasLinks,
        HasHero,
        HasTranslations,
        InteractsWithMedia,
        SoftDeletes,
        MintsNfts;

    protected $with = [
        'nfts',
    ];

    protected $casts = [
        'updated_at' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
        'recorded_at' => 'datetime:Y-m-d',
        'published_at' => 'datetime:Y-m-d',
    ];

    public $translatable = [
        'title',
        'meta_title',
        'content',
        'social_excerpt',
        'comment_prompt',
    ];

    /**
     * Get the user's first name.
     */
    protected function streamId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->youtube_id,
        );
    }

    /**
     * Get the user's first name.
     */
    protected function isScheduled(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->published_at?->isFuture(),
        );
    }

    /**
     * Get the user's first name.
     */
    protected function streamLink(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->published_link,
        );
    }

    public function getThumbnailUrlAttribute()
    {
        if (isset($this->attributes['thumbnailUrl'])) {
            return $this->attributes['thumbnailUrl'];
        }

        return $this->hero?->getfullUrl('thumbnail') ?? $this->nfts?->shuffle()?->first()?->preview_link;
    }

    public function link(): Attribute
    {
        return Attribute::make(
            get: fn () => '' 
        );
    }

    public function nfts(): HasMany
    {
        return $this->hasMany(Nft::class, 'model_id')
            ->where('model_type', static::class);
        //            ->whereHas('promos');
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function show(): BelongsTo
    {
        return $this->belongsTo(PodcastShow::class);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(PodcastSeason::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(640)
            ->height(420)
            ->withResponsiveImages()
            ->crop(Manipulations::CROP_TOP, 512, 512)
            ->performOnCollections('hero');
        $this->addMediaConversion('large')
            ->width(2400)
            ->height(1600)
            ->crop(Manipulations::CROP_TOP, 2048, 2048)
            ->withResponsiveImages()
            ->performOnCollections('hero');
    }
}
