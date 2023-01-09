<?php

namespace App\Models\Traits;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasRatings
{
    public function getTotalRatingsPercentDataAttribute()
    {
        $total = $this->ratings->count();

        return $this->ratings->groupBy('rating')->map(fn ($group) => ([
            'count' => $group->count(),
            'percent' => intval($group->count() / $total * 100),
        ]))->sortkeysdesc();
    }

    public function getRatingsCountAttribute()
    {
        return $this->discussions->sum(fn ($d) => ($d->ratings_count));
    }

    public function getRatingsAttribute()
    {
        return $this->discussions
            ?->map(fn ($disc) => $disc->ratings)
            ->collapse();
    }

    public function getRatingsAverageFormattedAttribute()
    {
        return number_format((float) $this->ratings_average, 2, '.', '');
    }

    public function getRatingsAverageAttribute()
    {
        return $this->discussions()
            ->with('ratings')
            ->get()
            ->map(fn ($disc) => $disc->ratings)
            ->collapse()->avg('rating');
    }

//    public function ratings(): HasMany
//    {
//        return $this->hasMany(Rating::class, 'model_id')
//            ->where('model_type', static::class);
//    }
//
//    public function getCommunityRatingsAttribute()
//    {
//        return $this->ratings->whereNotIn('user_id', [$this->user_id]);
//    }
//
//    public function getCommunityReviewsAttribute()
//    {
//        return $this->comments->whereNotIn('user_id', [$this->user_id]);
//    }
}
