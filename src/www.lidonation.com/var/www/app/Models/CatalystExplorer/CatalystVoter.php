<?php

namespace App\Models\CatalystExplorer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatalystVoter extends Model
{
    protected $with = [];

    protected $appends = [];

    public function registrations(): HasMany
    {
        return $this->hasMany(CatalystRegistration::class, 'stake_pub', 'stake_pub');
    }

    public function voting_powers(): HasMany
    {
        return $this->hasMany(CatalystVotingPower::class, 'voter_id', 'cat_id');
    }
}
