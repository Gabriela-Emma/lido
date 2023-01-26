<?php

namespace App\Models;

use App\Traits\SearchableLocale;
use Illuminate\Support\Str;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Foundation\Application;
use Parental\HasParent;
use Spatie\Comments\Models\Concerns\HasComments;
use Spatie\Feed\FeedItem;

class ExternalPost extends Post
{
    use HasParent, SearchableLocale, HasComments;

    protected $with = ['media', 'tags.media', 'categories.media', 'author.media'];

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     *
     * @throws \ReflectionException
     */
    public function getMorphClass()
    {
        return self::class;
    }

    public function getSummaryAttribute()
    {
        return Str::words($this->content, 24);
    }

    public function getPostTypeNameAttribute(): string
    {
        return 'external_posts';
    }

    public function getLinkAttribute(): string|UrlGenerator|Application
    {
        return $this->links->pluck('link')->toArray()[0];
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->summary)
            ->updated($this->updated_at)
            ->link($this->link)
            ->authorEmail($this->author?->email ?? config('app.email'))
            ->authorName($this?->author?->name);
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
        return parent::searchableAs();
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return parent::toSearchableArray();
    }
}
