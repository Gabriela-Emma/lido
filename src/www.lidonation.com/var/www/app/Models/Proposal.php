<?php

namespace App\Models;

use App\Models\Interfaces\HasLink;
use App\Models\Traits\HasCommits;
use App\Models\Traits\HasDiscussions;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasLinks;
use App\Models\Traits\HasLocaleUrl;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasRepos;
use App\Models\Traits\HasTaxonomies;
use App\Models\Traits\HasTranslations;
use App\Scopes\OrderByDateScope;
use App\Traits\SearchableLocale;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Actionable;
use Spatie\Comments\Models\Concerns\HasComments;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * to index run php artisan ln:index 'App\Models\Proposal' ln__proposals
 */
class Proposal extends Model implements HasMedia, Interfaces\IHasMetaData, Sitemapable, HasLink
{
    use Actionable,
        SoftDeletes,
        HasComments,
        HasCommits,
        HasTimestamps,
        HasMetaData,
        HasRepos,
        HasTaxonomies,
        HasLinks,
        InteractsWithMedia,
        HasDiscussions,
        SearchableLocale,
        HasTranslations,
        HasLocaleUrl,
        HasHero,
        HasRelationships;

    public static string $group = 'Catalyst';

    public static int $perPageViaRelationship = 15;

    protected string $urlGroup = 'proposals';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        //        'commits',
        'fund',
        'media',
        'metas',
        'ratings',
        'repos',
        'tags',
        'users',
    ];

    protected $withCount = ['ratings'];

    public $translatable = [
        'title',
        'meta_title',
        'problem',
        'solution',
        'experience',
        'content',
    ];

    public $translatableExcludedFromGeneration = [
        'meta_title',
    ];

    protected $guarded = ['user_id', 'created_at', 'funded_at'];

    protected $casts = [
        'title' => 'string',
        'meta_data' => 'array',
        'updated_at' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
        'funded_at' => 'datetime:Y-m-d',
        'amount_requested' => 'integer',
        'amount_received' => 'integer',
        'funding_updated_at' => 'date:Y-m-d',
    ];

    public static function getFilterableAttributes(): array
    {
        return [
            'funded',
            'completed',
            'has_quick_pitch',
            'impact_proposal',
            'woman_proposal',
            'ideafest_proposal',
            'ca_rating',
            'over_budget',
            'challenge',
            'groups',
            'amount_requested',
            'amount_received',
            'paid',
            'fund',
            'type',
            'users',
            'tags',
            'funding_status',
            'status',
        ];
    }

    public static function getSearchableAttributes(): array
    {
        return [
            'title',
            'website',
            'excerpt',
            'content',
            'problem',
            'experience',
            'solution',
            'definition_of_success',
            'comment_prompt',
            'social_excerpt',
            'users',
            'tags',
            //            'users.name',
            //            'users.email'
        ];
    }

    public static function getSortableAttributes(): array
    {
        return [
            'title',
            'amount_requested',
            'amount_received',
            'ca_rating',
            'created_at',
            'funded_at',
            'no_votes_count',
            'yes_votes_count',
        ];
    }

    public static function getRankingRules(): array
    {
        return [
            'words',
            'typo',
            'proximity',
            'attribute',
            'sort',
            'exactness',
        ];
    }

    public static function runCustomIndex()
    {
        Artisan::call('ln:index App\\\\Models\\\\Proposal ln__proposals');
    }

    public function getIsImpactProposalAttribute()
    {
        if ($this->meta_data?->impact_proposal) {
            return boolval($this->meta_data?->impact_proposal);
        }

        return false;
    }

    public function getIsWomanProposalAttribute()
    {
        if ($this->meta_data?->woman_proposal) {
            return boolval($this->meta_data?->woman_proposal);
        }

        return false;
    }

    public function getIsIdeafestProposalAttribute()
    {
        if ($this->meta_data?->ideafest_proposal) {
            return boolval($this->meta_data?->ideafest_proposal);
        }

        return false;
    }

    public function currency(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->currency ?? $this->challenge->currency ?? $this->fund->currency ?? null,
        );
    }

    public function getCurrencySymbolAttribute()
    {
        if ($this->currency) {
            return match ($this->currency) {
                'ADA' => '₳',
                'USD' => '$',
            };
        } else {
            return $this->fund->currency_symbol;
        }
    }

    public function getFormattedAmountRequestedAttribute()
    {
        return $this->currency_symbol.number_format($this->amount_requested, 0, '.', ',');
    }

    public function getFormattedAmountReceivedAttribute()
    {
        return $this->currency_symbol.number_format($this->amount_received, 0, '.', ',');
    }

    public function getGroupAttribute()
    {
        return $this->groups->first();
    }

    public function getCompletedAttribute()
    {
        return $this->funded_at ? true : false;
    }

    public function getFundedAttribute()
    {
        return $this->funded_at ? true : false;
    }

    public function getNoVotesCountFormattedAttribute()
    {
        if (! isset($this->no_votes_count)) {
            return $this->no_votes_count;
        }

        return '₳ '.number_format($this->no_votes_count, 0, '.', ',');
    }

    public function getYesVotesCountFormattedAttribute()
    {
        if (! isset($this->yes_votes_count)) {
            return $this->yes_votes_count;
        }

        return '₳ '.number_format($this->yes_votes_count, 0, '.', ',');
    }

    public function getGeneratedSummaryPicAttribute(): string|UrlGenerator|Application
    {
        $locale = App::currentLocale();

        return url(
            "images/{$this->slug}/$locale/{$this->slug}-cardano-catalyst-proposal-summary-card.jpeg"
        );
    }

    public function getQuickPitchIdAttribute()
    {
        return collect(explode('/', $this->meta_data?->quick_pitch))?->last();
    }

    public function getQuickPitchAttribute()
    {
        return $this->meta_data?->quick_pitch;
    }

    public function getVideosAttribute()
    {
        return $this->metas
            ->filter(fn ($m) => Str::contains($m->key, ['quick_pitch', 'youtube', 'video', '.mp4', 'vimeo']))
            ->map(function ($m) {
                $m->content = Str::replace('youtu.be/', 'youtube.com/watch?v=', $m->content);
                if (Str::contains($m->content, 'youtube')) {
                    $m->key = 'youtube';
                }

                return $m;
            })->sortBy('key');
    }

    public function RatingsAverageFormatted(): Attribute
    {
        return Attribute::make(fn () => number_format((float) $this->ratings_average, 2, '.', ''));
    }

    public function RatingsAverage(): Attribute
    {
        return Attribute::make(get: fn () => $this->ratings->avg('rating'));
    }

    public function scopeFundedChallengeSetting($query)
    {
        return $query->whereNotNull('funded_at');
    }

    public function scopeChallengeSettingProposals($query)
    {
        return $query->where('type', 'challenge');
    }

    public function scopeFundingProposals($query)
    {
        return $query->where('type', 'proposal');
    }

    public function scopeOrderByDateDesc($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }

    public function scopeFunded($query)
    {
        return $query->whereNotNull('funded_at')
            ->whereHas(
                'fund',
                fn (Builder $query) => $query->whereDoesntHave(
                    'categories',
                    fn (Builder $query) => $query->where('slug', '=', 'challenge-setting')
                )
            );
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn (Builder $query, $search) => $query->where('title', 'ILIKE', '%'.$search.'%')
        );

        $query->when($filters['user_id'] ?? false, fn (Builder $query, $user_id) => $query->where('user_id', $user_id)
        );

        $query->when($filters['challenge_id'] ?? false, fn (Builder $query, $fund_id) => $query->where('fund_id', $fund_id)
        );

        $query->when($filters['fund_id'] ?? false, fn (Builder $query, $fund_id) => $query->whereRelation('fund.parent', 'id', '=', $fund_id)
        );
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
            ->width(640)
            ->height(420)
            ->withResponsiveImages()
            ->crop(Manipulations::CROP_TOP, 512, 512)
            ->performOnCollections('hero');
        $this->addMediaConversion('large')
            ->width(2400)
            ->height(1600)
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

    public function discussions(): HasMany
    {
        return $this->hasMany(ProposalDiscussion::class, 'model_id')
            ->where('model_type', '=', static::class)
            ->withCount(['ratings'])
            ->withAvg('ratings', 'rating');
    }

    public function monthly_reports(): HasMany
    {
        return $this->hasMany(CatalystReport::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(
            CatalystGroup::class,
            'catalyst_group_has_proposal',
            'proposal_id',
            'catalyst_group_id',
            'id',
            'id',
            'groups');
    }

    public function fund(): BelongsTo
    {
        return $this->belongsTo(Fund::class, 'fund_id', 'id', 'fund');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(CatalystUser::class, 'user_id', 'id', 'author');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(ProposalRating::class, 'proposal_id');
    }

    public function toSitemapTag(): Url|string|array
    {
        return route('proposal', $this);
    }

    /**
     * Get the value used to index the model.
     */
    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        return array_merge($array, [
            'funded' => (bool) $this->funded_at ? 1 : 0,
            'has_quick_pitch' => (bool) $this->quick_pitch ? 1 : 0,
            'completed' => $this->status === 'complete' ? 1 : 0,
            'over_budget' => $this->status === 'over_budget' ? 1 : 0,
            'challenge' => $this->fund?->id,
            'currency' => $this->currency,
            'challenge_label' => $this->fund?->label,
            'fund' => $this->fund?->parent?->id,
            'groups' => $this->groups,
            'fund_label' => $this->fund?->parent?->label,
            'fund_status' => $this->fund?->status,
            'ca_rating' => $this->ratings_average ?? 0.00,
            'amount_requested' => $this->amount_requested ? intval($this->amount_requested) : 0,
            'amount_received' => $this->amount_received ? intval($this->amount_received) : 0,
            'paid' => $this->amount_received == $this->amount_requested ? 1 : 0,
            'impact_proposal' => $this->is_impact_proposal ? 1 : 0,
            'woman_proposal' => $this->is_woman_proposal ? 1 : 0,
            'ideafest_proposal' => $this->is_ideafest_proposal ? 1 : 0,
        ]);
    }

    /**
     * Modify the query used to retrieve models when making all of the models searchable.
     *
     * @param  Builder  $query
     */
    protected function makeAllSearchableUsing($query): Builder
    {
        return $query->with(['users', 'tags', 'groups']);
    }

    /**
     * The roles that belong to the user.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(CatalystUser::class, 'catalyst_user_has_proposal', 'proposal_id', 'catalyst_user_id');
    }

    public function toJS()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'quickPitch' => $this->quick_pitch,
            'quickPitchId' => $this->quick_pitch_id,
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope(new OrderByDateScope);
    }

    public function commentableName(): string
    {
        // TODO: Implement commentableName() method.
    }

    public function commentUrl(): string
    {
        // TODO: Implement commentUrl() method.
    }
}
