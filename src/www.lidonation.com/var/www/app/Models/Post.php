<?php

namespace App\Models;

use App\Enums\ReactionEnum;
use App\Models\Interfaces\HasLink;
use App\Models\Reactions\HasReactions;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasEditor;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasLinks;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasParent;
use App\Models\Traits\HasPrompts;
use App\Models\Traits\HasSlug;
use App\Models\Traits\HasSnippets;
use App\Models\Traits\HasTaxonomies;
use App\Models\Traits\HasTranslations;
use App\Scopes\LimitScope;
use App\Scopes\OrderByDateScope;
use App\Scopes\OrderByOrderScope;
use App\Scopes\OrderByPublishedDateScope;
use App\Scopes\PublishedScope;
use App\Traits\HasRemovableGlobalScopes;
use App\Traits\SearchableLocale;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Actionable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Parental\HasChildren;
use Spatie\Comments\Models\Concerns\HasComments;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

/**
 * @property int $id
 * @property string thumbnail_url
 */
class Post extends Model implements Feedable, HasLink, HasMedia, Interfaces\IHasMetaData, Sitemapable
{
    use Actionable,
        HasAuthor,
        HasChildren,
        HasComments,
        HasEditor,
        HasHero,
        HasLinks,
        HasMetaData,
        HasParent,
        HasPrompts,
        HasReactions,
        HasRemovableGlobalScopes,
        HasSlug,
        HasSnippets,
        HasTaxonomies,
        HasTimestamps,
        HasTranslations,
        InteractsWithMedia,
        SearchableLocale,
        SoftDeletes;

    public $translatable = [
        'title',
        'subtitle',
        'excerpt',
        'content',
        'prologue',
        'epilogue',
        'meta_title',
        'content_audio',
        'comment_prompt',
        'social_excerpt',
    ];

    public $translatableExcludedFromGeneration = [
        'content_audio',
    ];

    protected $appends = [
        'link',
    ];

    protected $guarded = ['user_id', 'created_at', 'published_at'];

    protected $withCount = [
        //        'comments',
        //        'hearts',
        //        'eyes',
        //        'party_popper',
        //        'rocket',
        //        'thumbs_down',
        //        'thumbs_up',
    ];

    protected $with = ['translations'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime:M d y',
        'published_at' => 'datetime:M d y',
        'content' => 'array',
    ];

    //    public function reactionsCounts(): Attribute
    //    {
    //        return Attribute::make(get: function () {
    //            $counts = [];
    //
    //            foreach (ReactionEnum::REACTIONS as $reaction => $class) {
    //                $counts[$reaction] = $this->lido_reactions()
    //                    ->where('type', $class)
    //                    ->count();
    //            }
    //
    //            return (array) $counts;
    //        });
    //    }

    public static function getFilterableAttributes(): array
    {
        return [
            'status',
            'user_id',
            'published_at',
            'type',
        ];
    }

    public static function getSearchableAttributes(): array
    {
        return [
            'title',
            'excerpt',
            'content',
            'comment_prompt',
            'social_excerpt',
        ];
    }

    public static function getSortableAttributes(): array
    {
        return [
            'order',
            'published_at',
        ];
    }

    public static function runCustomIndex()
    {
        Artisan::call('ln:index App\\\\Models\\\\Post ln__posts');
        Artisan::call('ln:index App\\\\Models\\\\Post ln__posts_es');
        Artisan::call('ln:index App\\\\Models\\\\Post ln__posts_fr');
        Artisan::call('ln:index App\\\\Models\\\\Post ln__posts_sw');
    }

    public function getTypeNameAttribute(): string
    {
        return Str::plural(class_basename($this));
    }

    public function getExcerptAttribute($value): string
    {
        if (isset($value)) {
            return $value;
        }

        return Str::words($this->content, 80);
    }

    public function getSocialPostAttribute()
    {
        return $this->social_excerpt ?? $this->summary;
    }

    public function getHashTagsAttribute()
    {
        return $this->tags->concat($this->categories)->map(fn ($tax) => Str::remove(' ', $tax->title));
    }

    public function getSummaryAttribute()
    {
        return $this?->excerpt ?? Str::words($this->content, 80);
    }

    public function link(): Attribute
    {
        return Attribute::make(get: fn () => LaravelLocalization::localizeURL(app()->getLocale()."/posts/{$this->slug}/"));
    }

    public function getRecordingLinkAttribute(): string|UrlGenerator|Application
    {
        return LaravelLocalization::localizeURL("/contribute-content/audio/{$this->slug}/");
    }

    public function getAudioAttribute()
    {
        if (isset($this->content_audio) && intval($this->content_audio) > 0) {
            return "https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/{$this->content_audio}&color=%23ff5500&inverse=true&auto_play=false&show_user=false";
        }

        if (isset($this->attributes['audio'])) {
            return $this->attributes['audio'];
        }

        return null;
    }

    public function getUrlAttribute()
    {
        return $this->link;
    }

    public function getPublishedAtFormattedAttribute()
    {
        return $this->published_at?->formatLocalized('%b %d %Y');
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return $this->updated_at?->formatLocalized('%b %d %Y');
    }

    /*
     * This string will be used in notifications on what a new comment
     * was made.
     */
    public function commentableName(): string
    {
        return $this->title;
    }

    /*
     * This URL will be used in notifications to let the user know
     * where the comment itself can be read.
     */
    public function commentUrl(): string
    {
        return $this->link;
    }

    /**
     * Determine if the user owns the given team.
     *
     * @param  mixed  $team
     */
    public function ownsTeam($team): bool
    {
        if (is_null($team)) {
            return false;
        }

        return $this->id == $team->{$this->getForeignKey()};
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->formatLocalized('%b %d %Y');
    }

    public function getChildrenAttribute(): ?Collection
    {
        return self::where('parent_id', '=', $this->id)->get();
    }

    public function getPostTypeNameAttribute(): string
    {
        return 'posts';
    }

    public function getPostTypeUrlAttribute(): string
    {
        return match ($this->post_type_name) {
            'reviews' => localizeRoute('reviews'),
            'lido-minutes' => localizeRoute('lido-minute'),
            'post' => localizeRoute('post', ['slug' => $this->slug]),
            default => localizeRoute('library'),
        };
    }

    public function getContentContributedIdeaAttribute()
    {
        return $this->metas?->firstWhere('key', 'idea')?->content;
    }

    public function getContentContributedLinksAttribute()
    {
        return $this->metas?->firstWhere('key', 'links')?->content;
    }

    public function getContentContributedLinkAttribute()
    {
        return $this->metas?->firstWhere('key', 'link')?->content;
    }

    public function getContentContributedCommentsAttribute()
    {
        return $this->metas?->firstWhere('key', 'author_comments')?->content;
    }

    public function getContentContributedEmailAttribute()
    {
        return $this->metas?->firstWhere('key', 'author_email')?->content;
    }

    public function getContentContributedAuthorAttribute()
    {
        return $this->metas?->firstWhere('key', 'submitted_by')?->content;
    }

    public function getVotesAttribute(): int
    {
        return $this->metas?->firstWhere('key', 'votes')?->content ?? 0;
    }

    public function scopeRecorded($query)
    {
        return $query->whereNotNull('content_audio');
    }

    public function scopeUnrecorded($query)
    {
        return $query->whereNull('content_audio');
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

    public function toSitemapTag(): Url|string|array
    {
        return route('post', $this);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $content = preg_replace('/\b((https?|ftp|file):\/\/|www\.)[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', ' ', $this->content);

        return array_merge($array, [
            'thumbnail' => $this->thumbnail_url,
            'content' => $content,
            'link' => LaravelLocalization::localizeURL("/posts/{$this->slug}/", app()->getLocale()),
            'read_time' => (string) read_time($this->content),
            'author_name' => $this->author?->name,
            'author_gravatar' => $this->author?->gravatar,
        ]);
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

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'lesson_post');
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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new PublishedScope);
        static::addGlobalScope(new OrderByOrderScope);
        static::addGlobalScope(new OrderByPublishedDateScope);
        static::addGlobalScope(new OrderByDateScope);
        if (! app()->runningInConsole()) {
            static::addGlobalScope(new LimitScope);
        }
    }
}
