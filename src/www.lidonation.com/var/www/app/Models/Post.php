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
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Actionable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Parental\HasChildren;
use Spatie\Comments\Models\Concerns\HasComments;
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
class Post extends Model implements HasMedia, Interfaces\IHasMetaData, Sitemapable, HasLink
{
    use Actionable,
        HasAuthor,
        HasChildren,
        HasComments,
        HasReactions,
        HasEditor,
        HasHero,
        HasMetaData,
        HasRemovableGlobalScopes,
        HasTimestamps,
        HasPrompts,
        HasParent,
        HasSnippets,
        HasLinks,
        HasTaxonomies,
        HasTranslations,
        InteractsWithMedia,
        SearchableLocale,
        SoftDeletes;

//    public int|DateTime|null $cacheFor = 900;

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     */
    protected static bool $flushCacheOnUpdate = true;

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

    protected $guarded = ['user_id', 'created_at', 'published_at'];

    protected $withCount = [
        'comments',
        'hearts',
        'eyes',
        'party_popper',
        'rocket',
        'thumbs_down',
        'thumbs_up',
    ];

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

    public function reactionsCounts(): Attribute
    {
        return Attribute::make(get: function () {
            $counts = [];

            foreach (ReactionEnum::REACTIONS as $reaction => $class) {
                $counts[$reaction] = $this->lido_reactions()
                    ->where('type', $class)
                    ->count();
            }

            return (array) $counts;
        });
    }

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

    public function getTypeNameAttribute()
    {
        return Str::plural(class_basename($this));
    }

    public function getExcerptAttribute($value)
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

    public function getRelatedPostsAttribute()
    {
    //     $taxs = $this->tags
    //         ->concat($this->categories);
    //     $query = $this::where('id', '!=', $this->id);
    //     $query = app(PostRepository::class)
    //         ->setQuery($query)
    //         ->inTaxonomies(null, $taxs)
    //         ->limit(5);

    //     // @TODO fix query above sometimes returns a collection with the current post
    //     return $query->get()
    //         ->whereNotIn('id', $this->id)->take(4);

        // get related categories ids in Array
        $categories_id = $this->categories->pluck('id');
        $rel_cat_ids = ModelCategory::whereIn('category_id', $categories_id)
            ->pluck('model_id');

        // get related tags ids in Array
        $tags_id = $this->tags->pluck('id');
        $rel_tags_ids = ModelTag::whereIn('tag_id', $tags_id)
            ->pluck('model_id');

        // concatinate rel_cat_ids with rel_tags_ids
        $related_ids = $rel_cat_ids->concat($rel_tags_ids);

        // get related posts from the related_ids array.
        $related_posts = Post::select('*')
            ->whereIn('id', $related_ids)
            ->where('id', '!=', $this->id)
            ->get();

        // @TODO fix query above sometimes returns a collection with the current post
        return $related_posts->take(4);
    }

    public function getLinkAttribute(): string|UrlGenerator|Application|null
    {
        return LaravelLocalization::localizeURL("/posts/{$this->slug}/");
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
     * @return bool
     */
    public function ownsTeam($team)
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

    public function getChildrenAttribute(): Collection|null
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
            'news' => localizeRoute('news'),
            'reviews' => localizeRoute('reviews'),
            'insights' => localizeRoute('insights'),
            default => 'posts' // localizeRoute('post', [$this->slug]),
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

    /**
     * Generate unique slug
     *
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
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
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
