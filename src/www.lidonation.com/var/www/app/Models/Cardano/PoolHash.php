<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PoolHash extends DbSyncModel
{
    use HasFactory;

    protected $table = 'pool_hash';

    public function owners(): HasMany
    {
        return $this->hasMany(PoolOwner::class, 'pool_hash_id');
    }

    public function poolUpdates(): HasMany
    {
        return $this->hasMany(PoolUpdate::class, 'hash_id');
    }

    public function poolRetirements(): HasMany
    {
        return $this->hasMany(PoolRetire::class, 'hash_id');
    }

    public function delegations(): HasMany
    {
        return $this->hasMany(Delegation::class);
    }
}
