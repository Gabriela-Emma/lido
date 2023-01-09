<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalRating extends Model
{
    protected $table = '_proposal_ratings';

    protected $with = [];

    public int|DateTime|null $cacheFor = 3600;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }
}
