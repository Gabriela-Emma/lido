<?php

namespace App\Models\CatalystExplorer;

use App\Models\Delegation;
use App\Models\Model;
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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'consumed' => 'boolean',
    ];

    public function catalyst_snapshot(): BelongsTo
    {
        return $this->belongsTo(CatalystSnapshot::class, 'catalyst_snapshot_id', 'id');
    }

    public function snapshot(): BelongsTo
    {
        return $this->belongsTo(CatalystSnapshot::class, 'catalyst_snapshot_id', 'id');
    }

    public function delegations(): HasMany
    {
        return $this->hasMany(Delegation::class, 'cat_onchain_id', 'voter_id');
    }

    public function voter(): BelongsTo
    {
        return $this->belongsTo(CatalystVoter::class, 'voter_id', 'cat_id');
    }
}
