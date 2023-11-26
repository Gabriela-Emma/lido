<?php

namespace App\Models\CatalystExplorer;

use App\Models\Traits\HasGravatar;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasLocaleUrl;
use App\Models\Traits\HasMetaData;
use App\Models\User;
use App\Traits\SearchableLocale;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Artisan;
use JetBrains\PhpStorm\Pure;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Comments\Models\Concerns\InteractsWithComments;
use Spatie\Comments\Models\Concerns\Interfaces\CanComment;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

/**
 * to index run php artisan ln:index 'App\Models\CatalystLidoUser' ln__catalyst_users
 */
class CatalystUser extends User implements CanComment, HasMedia
{
    use HasGravatar,
        HasHero,
        HasJsonRelationships,
        HasLocaleUrl,
        HasMetaData,
        HasRelationships,
        InteractsWithComments,
        InteractsWithMedia,
        SearchableLocale;

    protected $fillable = ['bio', 'twitter', 'discord', 'linkedin', 'ideascale', 'email'];

    public $table = 'catalyst_users';

    protected $hidden = ['email'];

    protected $withCount = ['own_proposals', 'proposals'];

    public $appends = ['co_proposals_count'];

    protected string $urlGroup = 'project-catalyst/users';

    protected $casts = [
        'name' => 'string',
        'amount_awarded_ada' => 'integer',
        'amount_awarded_usd' => 'integer',
    ];

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
            'proposals',
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
            'proposals.tags',
            'proposals_approved',
            'proposals_total_amount_requested',

        ];
    }

    public static function getSortableAttributes(): array
    {
        return [
            'name',
            'proposals_count',
            'proposals_completed',
            'amount_awarded_ada',
            'amount_awarded_usd',
            'own_proposals_count',
            'co_proposals_count',

        ];
    }

    public static function runCustomIndex()
    {
        Artisan::call('ln:index App\\\\Models\\\\CatalystExplorer\\\\CatalystUser ln__catalyst_users');
    }

    public function getFirstTimerAttribute(): bool
    {
        return count(array_unique(
            $this->proposals->map(fn ($p) => $p->fund?->parent_id)->toArray()
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

    public function coProposals(): Attribute
    {
        return Attribute::make(get: function (){
            $ownProposalIds = $this->own_proposals->pluck('id');

        return $this->proposals()->whereNotIn('id', $ownProposalIds)->count();
        });
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
    public function groups($groups = null)
    {
        return $this->belongsToMany(Group::class, 'catalyst_group_has_catalyst_user', 'catalyst_user_id', 'catalyst_group_id');
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
        $proposals = $this->proposals->map(fn ($p) => $p->toArray());

        return array_merge($array, [
            'proposals' => $proposals,
            'proposals_completed' => $proposals->filter(fn ($p) => $p['status'] === 'complete')?->count() ?? 0,
            'first_timer' => ($proposals?->map(fn ($p) => $p['fund']['id'])->unique()->count() === 1),
            'proposals_approved' => $proposals->filter(fn ($p) => (bool) $p['funded_at'])?->count() ?? 0,
            'amount_awarded_ada' => $this->amount_awarded_ada,
            'amount_awarded_usd' => intval($this->amount_awarded_usd),
            'co_proposals_count' => intval($this-> co_proposals_count),
            'proposals_total_amount_requested' => intval($proposals->filter(fn ($p) => (bool) $p['amount_requested'])?->sum('amount_requested')) ?? 0,
        ]);
    }

    public function amountAwardedAda(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->proposals()->whereNotNull('funded_at')
                    ->sum('amount_requested');
            },
        );
    }

    public function amountAwardedUsd(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->proposals()->whereNotNull('funded_at')
                    ->sum('amount_requested');
            },
        );
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
