<?php

namespace App\Models;

use App\Models\Interfaces\HasLink;
use App\Models\Traits\HasMetaData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Taxonomy extends Model implements HasMedia, HasLink
{
    use HasFactory,
        SoftDeletes,
        HasTimestamps,
        HasMetaData,
        InteractsWithMedia;

    protected $with = ['media'];

    protected $withCount = ['insights', 'news'];

    protected $appends = ['posts_count'];

    protected $fillable = ['title'];

    public function getLinkAttribute(): string|UrlGenerator|Application
    {
        return LaravelLocalization::localizeURL("/tags/{$this->slug}/");
    }

    /**
     * Get the user's first name.
     *
     * @return Attribute
     */
    protected function postsCount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->insights_count + $this->news_count,
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

    /**
     * Get the user's first name.
     *
     * @return Attribute
     */
    protected function models(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value ?? $this->news->concat($this->reviews)->concat($this->insights))->sortByDesc('published_at'),
        );
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Generate unique slug
     *
     * @param $title
     * @return array|string ()
     */
    public function createSlug($title): array|string
    {
        if (static::whereSlug($slug = Str::slug($title))->exists()) {
            $max = intval(static::whereTitle($title)->latest('id')->count());

            return "{$slug}-".preg_replace_callback('/(\d+)$/', fn ($matches) => $matches[1] + 1,
                $max);
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
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
//        static::addGlobalScope(new PublishedScope);
//        static::addGlobalScope(new OrderByOrderScope);
//        static::addGlobalScope(new OrderByDateScope);
    }
}
