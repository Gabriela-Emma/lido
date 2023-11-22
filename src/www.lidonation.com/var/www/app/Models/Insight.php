<?php

namespace App\Models;

use App\Traits\SearchableLocale;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Parental\HasParent;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Insight extends Post implements Feedable
{
    use HasParent, SearchableLocale, SoftDeletes;

    protected $with = [];

    public function getSummaryAttribute()
    {
        return Str::words($this->content, 24);
    }

    public function getPostTypeNameAttribute(): string
    {
        return 'insights';
    }

    /**
     * Get the class name for polymorphic relations.
     *
     *
     * @throws \ReflectionException
     */
    public function getMorphClass(): string
    {
        return self::class;
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->summary)
            ->updated($this->updated_at)
            ->link($this->link)
            ->authorName($this->author->name)
            ->authorEmail($this->author->email);
    }

    public static function getFeedItems(): Collection|array
    {
        return self::all();
    }

    /**
     * Get the index able data array for the model.
     */
    public function toSearchableArray(): array
    {
        return parent::toSearchableArray();
    }

    /**
     * Get the index name for the model.
     */
    public function searchableAs(): string
    {
        return parent::searchableAs();
    }
}
