<?php

namespace App\Models;

use DateTime;
use JetBrains\PhpStorm\Pure;
use App\Models\Traits\HasHero;
use App\Traits\SearchableLocale;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Traits\HasGravatar;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasLocaleUrl;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Comments\Models\Concerns\InteractsWithComments;
use Spatie\Comments\Models\Concerns\Interfaces\CanComment;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * to index run php artisan ln:index 'App\Models\CatalystUser' ln__catalyst_users
 */
class CatalystUser extends User implements HasMedia, CanComment
{
    use HasGravatar,
        HasLocaleUrl,
        HasMetaData,
        HasRelationships,
        HasHero,
        InteractsWithMedia,
        InteractsWithComments,
        SearchableLocale,
        HasJsonRelationships;

    protected $fillable = ['bio', 'twitter', 'discord', 'linkedin', 'ideascale', 'email'];

    protected $table = 'catalyst_users';

    protected $hidden = ['email'];

    protected $withCount = ['own_proposals', 'proposals'];

    protected string $urlGroup = 'project-catalyst/users';

    public int|DateTime|null $cacheFor = 3600;

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     */
    protected static bool $flushCacheOnUpdate = true;

    public array $translatable = [
        'bio',
    ];

    public static function getSearchableAttributes(): array
    {
        return [
            'name',
            'username',
            'bio',
            'email',
            'proposals'
        ];
    }

    public static function getRankingRules(): array
    {
        return [
            'words',
            'sort',
            'attribute',
            'exactness',
        ];
    }

    public static function getFilterableAttributes(): array
    {
        return [
            'first_timer',
            'proposals_completed',
            'proposals_count',
            'proposals.challenge',
            'proposals.impact_proposal',
            'proposals.fund',
            'proposals.fund_status',

        ];
    }

    public static function getSortableAttributes(): array
    {
        return [
            'name',
            'proposals_count',
            'proposals_completed',
        ];
    }

    public static function runCustomIndex()
    {
        Artisan::call('ln:index App\\\\Models\\\\CatalystUser ln__catalyst_users');
    }

    public function getFirstTimerAttribute(): bool
    {
        return count(array_unique(
            $this->proposals->map(fn ($p) => $p->toSearchableArray())->pluck('fund')->toArray()
        )) === 1;
    }

    public function getBioAttribute()
    {
        if (isset($this->attributes['bio'])) {
            return $this->attributes['bio'];
        }

        return null;
    }

    public function getNameAttribute($value)
    {
        if (isset($this->attributes['name'])) {
            return $this->attributes['name'];
        }

        return $this->username;
    }


    public function displayName(): Attribute
    {
        return Attribute::make(get: fn () => $this->name ?? $this->claimed_by_user?->name);
    }

    public function notificationEmail(): Attribute
    {
        return Attribute::make(get: fn () => $this->email ?? $this->claimed_by_user?->email);
    }

    public function link(): Attribute
    {
        return Attribute::make(get: fn () => LaravelLocalization::localizeURL("/project-catalyst/users/{$this->id}/"));
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['search'] ?? false,
            fn (Builder $query, $search) => $query
                ->where('username', 'ILIKE', '%' . $search . '%')
                ->orWhere('name', 'ILIKE', '%' . $search . '%')
        );

        $query->when(
            $filters['ids'] ?? false,
            fn (Builder $query, $ids) => $query->whereIn('id', is_array($ids) ? $ids : explode(',', $ids))
        );

        $query->when(
            $filters['ideascale_username'] ?? false,
            fn (Builder $query, $username) => $query->where('username', $username)
        );
    }

    /**
     * The roles that belong to the user.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'notification_request_templates', 'what_filter->subject', 'who_id');
    }

    /**
     * The roles that belong to the user.
     */
    public function claimed_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'claimed_by', 'id', 'claimed_by_user');
    }

    /**
     * The proposals that belong to the user.
     */
    public function proposals(): BelongsToMany
    {
        return $this->belongsToMany(Proposal::class, 'catalyst_user_has_proposal', 'catalyst_user_id', 'proposal_id')
            ->where('type', 'proposal');
    }

    /**
     * The own_proposals that belong to the user.
     */
    public function own_proposals(): HasMany
    {
        return $this->hasMany(Proposal::class, 'user_id', 'id')
            ->where('type', 'proposal');
    }

    /**
     * The roles that belong to the user.
     */
    public function own_challenges(): HasMany
    {
        return $this->hasMany(Proposal::class, 'user_id', 'id')
            ->where('type', 'proposal');
    }

    /**
     * The roles that belong to the user.
     */
    public function own_proposals_and_challenges(): HasMany
    {
        return $this->hasMany(Proposal::class, 'user_id', 'id');
    }

    /**
     * groups user belong to.
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(CatalystGroup::class, 'catalyst_group_has_catalyst_user', 'catalyst_user_id', 'catalyst_group_id');
    }

    /**
     * The roles that belong to the user.
     */
    public function challenges(): BelongsToMany
    {
        return $this->belongsToMany(Proposal::class, 'catalyst_user_has_proposal', 'catalyst_user_id', 'proposal_id')
            ->where('type', 'challenge');
    }

    public function monthly_reports(): HasManyThrough
    {
        return $this->hasManyThrough(CatalystReport::class, Proposal::class, 'user_id', 'proposal_id');
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        $array = $this->toArray();
        $proposals = $this->proposals->map(fn ($p) => $p->toSearchableArray());

        return array_merge($array, [
            'proposals' => $proposals,
            'proposals_completed' => $proposals->filter(fn ($p) => $p['status'] === 'complete')?->count() ?? 0,
            'first_timer' => ($proposals?->map(fn ($p) => $p['fund']['id'])->unique()->count() === 1
            ),
        ]);
    }

    #[Pure]
    public function getGravatarEmailField(): string
    {
        if (!empty($this->email)) {
            return 'email';
        }

        return 'name';
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(768)
            ->height(512)
            ->withResponsiveImages()
            //            ->crop(Manipulations::CROP_TOP, 768, 512)
            ->performOnCollections('hero');
    }
}
