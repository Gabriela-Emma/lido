<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class ProposalDiscussion extends Discussion
{
    protected $table = 'discussions';

    public function comments(): HasMany
    {
        return $this->hasMany(LegacyComment::class, 'model_id')
            ->where('model_type', Discussion::class)
            ->whereNull('parent_id')
            ->limit(16);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'model_id')
            ->where('model_type', Discussion::class);
    }

    public function getCommunityRatingsAttribute()
    {
        return $this->ratings;
    }

    public function getCommunityReviewsAttribute()
    {
        return $this->comments;
    }
}
