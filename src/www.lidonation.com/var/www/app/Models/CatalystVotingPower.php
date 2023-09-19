<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function delegations(): HasMany
    {
        return $this->hasMany(Delegation::class, 'cat_onchain_id', 'voter_id');
    }
}
