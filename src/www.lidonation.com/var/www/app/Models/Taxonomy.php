<?php

namespace App\Models;

use App\Models\CatalystExplorer\Fund;
use App\Models\Interfaces\HasLink;
use App\Models\Traits\HasMetaData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Taxonomy extends Model implements HasLink, HasMedia
{
    use HasMetaData,
        HasTimestamps,
        InteractsWithMedia,
        SoftDeletes;

    protected $with = ['media'];

    protected $withCount = ['posts'];

    protected $fillable = ['title'];

    public function link(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => LaravelLocalization::localizeURL("/tags/{$this->slug}/"),
        );
    }

    public function getHeroUrlAttribute()
    {
        if (isset($this->attributes['heroUrl'])) {
            return $this->attributes['heroUrl'];
        }

        return $this->hero->getfullUrl('large');
    }

    public function getHeroAttribute()
    {
        $media = $this->media->filter(fn ($m) => $m->collection_name === 'hero');
        if ($media->isNotEmpty()) {
            return $media->first();
        }
        if ($this->parent) {
            if (isset($this->parent->media) && $this->parent->media->isNotEmpty()) {
                return $this->parent->media->first();
            }
        }
    }

    public function getThumbnailUrlAttribute()
    {
        if (isset($this->attributes['thumbnailUrl'])) {
            return $this->attributes['thumbnailUrl'];
        }
        if (! $this->hero?->hasGeneratedConversion('thumbnail')) {
            return null;
        }

        return $this->hero?->getfullUrl('thumbnail');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['search'] ?? false,
            fn (Builder $query, $search) => $query->whereFullText(['title'], "'{$search}':*", ['mode' => 'websearch'])
        );
        $query->when(
            $filters['ids'] ?? false,
            fn (Builder $query, $ids) => $query->whereIn('id', is_array($ids) ? $ids : explode(',', $ids))
        );
    }

    protected function currentFundProposals(): Attribute
    {
        $fund = Fund::where('parent_id', null)->first();

        return Attribute::make(
            get: fn ($value) => $this->proposals()->whereRelation('fund.parent', 'id', $fund?->id)->count(),
        );
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Generate unique slug
     *
     * @return array|string ()
     */
    public function createSlug($title): array|string
    {
        if (static::whereSlug($slug = Str::slug($title))->exists()) {
            $max = intval(static::whereTitle($title)->latest('id')->count());

            return "{$slug}-".preg_replace_callback(
                '/(\d+)$/',
                fn ($matches) => $matches[1] + 1,
                $max
            );
        }

        return $slug;
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'current_fund_proposals' => $this->current_fund_proposals,
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        //        static::addGlobalScope(new PublishedScope);
        //        static::addGlobalScope(new OrderByOrderScope);
        //        static::addGlobalScope(new OrderByDateScope);
    }
}
