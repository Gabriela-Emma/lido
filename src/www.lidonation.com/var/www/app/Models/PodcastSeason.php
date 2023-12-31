<?php

namespace App\Models;

use App\Models\Interfaces\HasLink;
use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasLinks;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PodcastSeason extends Model implements HasLink, HasMedia, IHasMetaData
{
    use HasAuthor, HasHero, HasLinks, HasMetaData, HasTranslations, InteractsWithMedia, SoftDeletes;

    public $translatable = [
        'name',
        'content',
    ];

    public function link(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ''
        );
    }

    public function show(): BelongsTo
    {
        return $this->belongsTo(PodcastShow::class, 'show_id');
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(Podcast::class, 'season_id');
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
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
