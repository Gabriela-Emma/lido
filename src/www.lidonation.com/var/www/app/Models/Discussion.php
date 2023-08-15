<?php

namespace App\Models;

use App\Models\Traits\HasAssessments;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasSnippets;
use App\Scopes\OrderByOrderScope;
use App\Scopes\PublishedScope;
use DateTime;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parental\HasChildren;

class Discussion extends Model implements Interfaces\IHasMetaData
{
    use HasTimestamps,
        HasAuthor,
        HasMetaData,
        HasAssessments,
        HasSnippets,
        HasChildren,
        SoftDeletes;

    public int|DateTime|null $cacheFor = 3600;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime:Y-m-d',
        'published_at' => 'datetime:Y-m-d',
    ];

    public function getRatingAttribute(): float
    {
        return floatval(
            number_format((float) $this->ratings_avg_rating, 1, '.', '')
        );
    }

    public function getCommunityRatingsAttribute()
    {
        return $this->ratings->whereNotIn('user_id', [$this->user_id]);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'model_id')
            ->where('model_type', static::class);
    }

    public function model(): BelongsTo
    {
        return $this->morphTo('model', 'model_type', 'model_id');
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class, 'model_id');
    }


    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'model_id');
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
    }
}
