<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Parental\HasParent;
use Spatie\Comments\Models\Concerns\HasComments;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class OnboardingContent extends Post implements Feedable
{
    use HasComments, HasFactory, HasParent;

    protected $with = ['media', 'tags.media', 'categories.media', 'author.media', 'snippets'];

    public function getSummaryAttribute()
    {
        return Str::words($this->content, 24);
    }

    public function getPostTypeNameAttribute(): string
    {
        return 'noobs';
    }

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
        return OnboardingContent::all();
    }
}
