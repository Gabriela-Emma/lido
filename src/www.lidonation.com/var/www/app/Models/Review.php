<?php

namespace App\Models;

use App\Models\Traits\HasComments;
use App\Models\Traits\HasDiscussions;
use App\Models\Traits\HasRatings;
use App\Traits\SearchableLocale;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Parental\HasParent;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Review extends Post implements Feedable
{
    use HasParent, HasDiscussions, HasRatings, SearchableLocale, HasComments;

    protected $with = ['media', 'tags.media', 'categories.media', 'author.media'];

    public function getSummaryAttribute()
    {
        return $this->excerpt ?? Str::words($this->content, 24);
    }

    public function getGeneratedSummaryPicAttribute(): string|UrlGenerator|Application
    {
        $locale = App::currentLocale();

        return url(
            "images/{$this->slug}/$locale/{$this->slug}-cardano-community-review-summary-card-{$this->ratings->count()}.jpeg"
        );
    }

    public function getSummaryPicAttribute(): string|UrlGenerator|Application
    {
        return LaravelLocalization::localizeURL("/reviews/{$this->slug}/summary-image/{$this->slug}-lidonation-cardano-community-review-summary-card");
    }

    public function getDisclaimerAttribute()
    {
        return $this->prologue;
    }

    public function getLinkAttribute(): string|UrlGenerator|Application
    {
        return LaravelLocalization::localizeURL("/reviews/{$this->slug}/");
    }

    public function getPostTypeNameAttribute(): string
    {
        return 'reviews';
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->summary)
            ->updated($this->updated_at)
            ->link($this->link)
            ->authorName($this->author->name);
    }

    public static function getFeedItems(): Collection|array
    {
        return self::all();
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return match (app()->getLocale()) {
            'es' => 'ln__posts_es',
            'fr' => 'ln__posts_fr',
            'sw' => 'ln__posts_sw',
            default => 'ln__posts',
        };
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($this->getRouteKeyName(), $value)
            ->withCount(['comments'])
            ->with(['discussions.ratings'])
            ->firstOrFail();
    }
}
