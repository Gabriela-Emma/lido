<?php

namespace App\Models;

use App\Enums\CatalystCurrencyEnum;
use App\Enums\CurrencySymbolEnum;
use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasAssessments;
use App\Models\Traits\HasHero;
use App\Models\Traits\HasLinks;
use App\Models\Traits\HasLocaleUrl;
use App\Models\Traits\HasParent;
use App\Models\Traits\HasTaxonomies;
use App\Scopes\OrderByLaunchedDateScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Fund extends Model implements HasMedia, IHasMetaData
{
    use SoftDeletes,
        HasTimestamps,
        InteractsWithMedia,
        HasTaxonomies,
        HasAssessments,
        HasParent,
        HasHero,
        HasLinks,
        HasLocaleUrl,
        HasRelationships,
        Traits\HasMetaData;

    protected $table = 'funds';

    protected $dateFormat = 'Y-m-d';

    protected $withCount = ['proposals', 'parent_proposals'];

    protected $with = ['media', 'parent'];

    protected $appends = ['link', 'hero_url', 'thumbnail_url'];

    //    protected string $urlGroup = 'project-catalyst/challenges';

    protected $casts = [
        'meta_data' => 'array',
        'updated_at' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
        'launched_at' => 'datetime:Y-m-d',
        'awarded_at' => 'datetime:Y-m-d',
        'assessment_started_at' => 'datetime:Y-m-d',
        'amount' => 'integer',
    ];

    public function currency(): Attribute
    {
        return Attribute::make(
            get: fn ($currency) => $currency ?? $this->parent?->currency ?? 'USD',
        );
    }

    public function getCurrencySymbolAttribute()
    {
        return match ($this->currency) {
            CatalystCurrencyEnum::ADA => CurrencySymbolEnum::ADA,
            default => CurrencySymbolEnum::USD
        };
    }

    public function getFormattedAmountAttribute()
    {
        return $this->currency_symbol.number_format($this->amount, 0, '.', ',');
    }

    public function getWiningProposalsAttribute()
    {
        return $this->proposals()->whereNotNull('funded_at')->get();
    }

    public function getOverBudgetProposalsAttribute()
    {
        return $this->proposals()->where('status', '=', 'over_budget')->get();
    }

    public function getColorAttribute()
    {
        if (isset($this->attributes['color'])) {
            return $this->attributes['color'];
        }

        return $this->parent?->color;
    }

    public function getLabelAttribute()
    {
        if (isset($this->attributes['label'])) {
            return $this->attributes['label'];
        }

        return $this->title;
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['search'] ?? false,
            fn (Builder $query, $search) => $query->where('title', 'ILIKE', '%'.$search.'%')
        );

        $query->when(
            $filters['fund_id'] ?? false,
            fn (Builder $query, $fund_id) => $query->where('parent_id', $fund_id)
        );
    }

    public function scopeChallengeSettings($query)
    {
        return $query
            ->whereHas(
                'categories',
                fn (Builder $query) => $query->where('slug', '=', 'challenge-setting')
            );
    }

    public function scopeFundedChallengeSettings($query)
    {
        return $query
            ->whereHas(
                'categories',
                fn (Builder $query) => $query->where('slug', '=', 'challenge-setting')
            )
            ->whereHas(
                'proposals',
                fn ($subquery) => $subquery->whereNotNull('proposals.funded_at')
            );
    }

    public function scopeFunded($query)
    {
        return $query
            ->whereDoesntHave(
                'categories',
                fn (Builder $query) => $query->where('slug', '=', 'challenge-setting')
            )
            ->whereHas(
                'proposals',
                fn ($subquery) => $subquery->whereNotNull('proposals.funded_at')
            );
    }

    public function scopeFunds($query)
    {
        return $query
            ->whereNull('parent_id');
    }

    public function scopeTopLevel($query)
    {
        return $this->funds();
    }

    public function scopeChallenges($query)
    {
        return $query
            ->whereNotNull('parent_id');
    }

    public function scopeInGovernance($query)
    {
        return $query->where('status', 'governance')
            ->whereNull('parent_id');
    }

    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function fundChallenges(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function siblingFundChallenges(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'parent_id');
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class, 'fund_id')
            ->where('type', 'proposal');
    }

    public function snapshot()
    {
        return $this->morphOne(CatalystSnapshot::class, 'model');
    }

    public function parent_proposals(): HasManyThrough
    {
        return $this->hasManyThrough(Proposal::class, self::class, 'parent_id', 'fund_id');
    }

    protected function getUrlGroup(): string
    {
        if (! $this->parent) {
            return 'catalyst-explorer/funds';
        }

        return 'catalyst-explorer/challenges';
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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new OrderByLaunchedDateScope);
    }
}
