<?php

namespace App\Models;

use App\Models\Traits\HasMetaData;
use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProposalRating extends Model
{
    use HasMetaData;

    protected $table = '_proposal_ratings';

    protected $with = [];

    protected $appends = ['meta_data'];

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

    public function metas(): HasMany
    {
        return $this->hasMany(Meta::class, 'model_id')->orWhere([
            'model_type' => static::class,
            'model_type' => Assessment::class
        ]);
    }
}
