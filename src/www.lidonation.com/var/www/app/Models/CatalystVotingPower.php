<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatalystVotingPower extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'voter_id',
        'voting_power',
        'catalyst_snapshot_id',
    ];

    public function catalyst_snapshot(): BelongsTo
    {
        return $this->belongsTo(CatalystSnapshot::class, 'catalyst_snapshot_id', 'id');
    }
}
