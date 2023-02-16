<?php

namespace App\Models;

use App\Models\Interfaces\HasLink;
use App\Models\Traits\HasGravatar;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTranslations;
use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;
use Chelout\RelationshipEvents\Traits\HasRelationshipObservables;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class CatalystGroup extends Model implements HasMedia, HasLink
{
    use HasFactory,
        HasGravatar,
        HasHero,
        HasMetaData,
        HasRelationships,
        HasBelongsToManyEvents,
        HasRelationshipObservables,
        HasTranslations,
        InteractsWithMedia;

    protected $withCount = ['proposals', 'members', 'owner', 'challenges'];

    /**
     * All the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['proposals'];

    public array $translatable = [
        'bio',
    ];

    public function getLinkAttribute(): string|UrlGenerator|Application
    {
        return LaravelLocalization::localizeURL("/project-catalyst/group/{$this->slug}/");
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
        return Attribute::make(get: fn() => $this->owner?->claimed_by_user);
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
//            ['catalyst_group_has_catalyst_user', CatalystUser::class, 'catalyst_user_has_proposal']
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
//            ['catalyst_group_has_catalyst_user', CatalystUser::class, 'catalyst_user_has_proposal']
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
     *
     * @return array
     */
    protected function getCacheBaseTags(): array
    {
        return [
            'catalyst_groups',
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
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
