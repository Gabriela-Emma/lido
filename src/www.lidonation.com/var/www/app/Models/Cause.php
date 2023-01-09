<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasComments;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasLinks;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Actionable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * * @property string $title
 */
class Cause extends Model implements HasMedia, Interfaces\IHasMetaData
{
    use Actionable,
        HasAuthor,
        HasComments,
        HasHero,
        HasLinks,
        HasMetaData,
        HasTimestamps,
        HasTranslations,
        InteractsWithMedia,
        SoftDeletes;

    protected $with = ['media'];

    public $translatable = [
        'title',
        'meta_title',
        'content',
    ];

    protected $guarded = ['user_id', 'created_at', 'published_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        'published_at' => 'datetime:Y-m-d',
    ];

    public function getSummaryAttribute()
    {
        return $this?->excerpt ?? Str::words($this->content, 40);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(512)
            ->height(512)
            ->withResponsiveImages()
            ->crop(Manipulations::CROP_TOP, 512, 512)
            ->performOnCollections('hero');
        $this->addMediaConversion('large')
            ->width(2048)
            ->height(2048)
            ->crop(Manipulations::CROP_TOP, 2048, 2048)
            ->withResponsiveImages()
            ->performOnCollections('hero');
    }
}
