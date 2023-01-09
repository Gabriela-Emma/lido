<?php

namespace App\Models;

use App\Traits\SearchableLocale;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Collection;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Parental\HasParent;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class LidoMinute extends Post implements Feedable
{
    use HasParent, SearchableLocale;

    public function getLinkAttribute(): string|UrlGenerator|Application
    {
        return LaravelLocalization::localizeURL("/lido-minutes/{$this->slug}/");
    }

    public function getPostTypeNameAttribute(): string
    {
        return 'lido-minutes';
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
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
    public function searchableAs(): string
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
            ->firstOrFail();
    }
}
