<?php

namespace App\Models\CatalystExplorer;

use App\Models\Interfaces\HasLink;
use App\Models\Model;
use App\Models\Traits\HasGravatar;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTranslations;
use App\Traits\SearchableLocale;
use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;
use Chelout\RelationshipEvents\Traits\HasRelationshipObservables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Artisan;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Group extends Model implements HasLink, HasMedia
{
    use HasBelongsToManyEvents,
        HasGravatar,
        HasHero,
        HasMetaData,
        HasRelationshipObservables,
        HasRelationships,
        HasTranslations,
        InteractsWithMedia,
        SearchableLocale;

    protected $table = 'catalyst_groups';

    protected $withCount = [
        'proposals',
        'members',
        'owner',
        'challenges'
    ];

    protected $appends = [
        'link',
        'thumbnail_url',
        'gravatar'
    ];

    protected $casts = [
        'name' => 'string',
        'amount_requested' => 'integer',
        'amount_awarded_ada' => 'integer',
        'amount_awarded_usd' => 'integer',
    ];

    /**
     * All the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['proposals'];

    public array $translatable = [
        'bio',
    ];

    public static function runCustomIndex()
    {
        Artisan::call('ln:index App\\\\Models\\\\CatalystExplorer\\\\Group ln__catalyst_groups');
    }

    public static function getFilterableAttributes(): array
    {
        return [
            'id',
            'members.id',
            'proposals',
            'proposals_approved',
            'proposals_completed',
        ];
    }

    public static function getSearchableAttributes(): array
    {
        return [
            'name',
            'proposals',
            'members',
            'owner',
        ];
    }

    public static function getSortableAttributes(): array
    {
        return [
            'name',
            'id',
            'website',
            'proposals_approved',
            'proposals_completed',
            'amount_awarded_ada',
            'amount_awarded_usd',
            'amount_requested',
        ];
    }

    public static function getRankingRules(): array
    {
        return [
            'words',
            'attribute',
            'exactness',
            'sort',
        ];
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        $this->load(['media']);
        $array = $this->toArray();
        $proposals = $this->proposals->map(fn ($p) => $p->toArray());

        return array_merge($array, [
            'proposals_completed' => $proposals->filter(fn ($p) => $p['status'] === 'complete')?->count() ?? 0,
            'members' => $this->members->map(fn ($m) => $m->toArray()),
            'owner' => $this->owner,
            'proposals_approved' => $proposals->filter(fn ($p) => (bool) $p['funded_at'])?->count() ?? 0,
            'amount_received' => intval($this->proposals()->whereNotNull('funded_at')->sum('amount_received')),
            'amount_awarded_ada' => intval($this->amount_awarded_ada),
            'amount_awarded_usd' => intval($this->amount_awarded_usd),
        ]);
    }

    public function link(): Attribute
    {
        return Attribute::make(
            get: fn () => LaravelLocalization::localizeURL("/project-catalyst/group/{$this->slug}/"),
        );
    }

    public function amountAwardedAda(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->proposals()->whereNotNull('funded_at')
                    ->whereHas('fund', function ($q) {
                        $q->where('currency', 'ADA');
                    })->sum('amount_requested');
            },
        );
    }

    public function amountAwardedUsd(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->proposals()->whereNotNull('funded_at')
                    ->whereHas('fund', function ($q) {
                        $q->where('currency', 'USD');
                    })->sum('amount_requested');
            },
        );
    }

    public function getUrlAttribute()
    {
        return $this->link;
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['search'] ?? false,
            fn (Builder $query, $search) => $query->where('name', 'ILIKE', '%'.$search.'%')
        );

        $query->when(
            $filters['ids'] ?? false,
            fn (Builder $query, $ids) => $query->whereIn('id', is_array($ids) ? $ids : explode(',', $ids))
        );
    }

    public function claimedBy(): Attribute
    {
        return Attribute::make(get: fn () => $this->owner?->claimed_by_user);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(CatalystUser::class, 'user_id', 'id', 'owner');
    }

    /**
     * The roles that belong to the user.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(CatalystUser::class, 'catalyst_group_has_catalyst_user', 'catalyst_group_id', 'catalyst_user_id');
    }

    /**
     * The roles that belong to the user.
     */
    public function proposals(): BelongsToMany
    {
        return $this->belongsToMany(Proposal::class, 'catalyst_group_has_proposal', 'catalyst_group_id', 'proposal_id', 'id', 'id', 'proposals')
            ->where('type', 'proposal');
        //        return $this->hasManyDeep(
        //            Proposal::class,
        //            ['catalyst_group_has_catalyst_user', CatalystLidoUser::class, 'catalyst_user_has_proposal']
        //        )->groupBy(['proposals.id'])->where('type', 'proposal');
    }

    /**
     * The roles that belong to the user.
     */
    public function challenges(): BelongsToMany
    {
        return $this->belongsToMany(Proposal::class, 'catalyst_group_has_proposal', 'catalyst_group_id', 'proposal_id', 'id', 'id', 'challenges')
            ->where('type', 'challenge');
        //        return $this->hasManyDeep(
        //            Proposal::class,
        //            ['catalyst_group_has_catalyst_user', CatalystLidoUser::class, 'catalyst_user_has_proposal']
        //        )->where('type', 'challenge')
        //            ->groupBy(['proposals.id']);
    }

    /**
     * The roles that belong to the user.
     */
    public function proposals_and_challenges(): BelongsToMany
    {
        return $this->belongsToMany(Proposal::class, 'catalyst_group_has_proposal', 'catalyst_group_id', 'proposal_id', 'id', 'id', 'proposals_and_challenges');
    }

    /**
     * Set the base cache tags that will be present
     * on all queries.
     */
    protected function getCacheBaseTags(): array
    {
        return [
            'catalyst_groups',
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(512)
            ->height(512)
            ->withResponsiveImages()
            ->crop(Manipulations::CROP_TOP, 512, 512)
            ->performOnCollections('hero');
    }
}
