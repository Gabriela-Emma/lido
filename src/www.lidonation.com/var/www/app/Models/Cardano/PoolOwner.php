<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PoolOwner extends DbSyncModel
{
    use HasFactory;

    protected $table = 'pool_owner';
}
