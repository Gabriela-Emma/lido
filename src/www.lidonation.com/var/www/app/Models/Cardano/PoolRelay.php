<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PoolRelay extends DbSyncModel
{
    use HasFactory;

    protected $table = 'pool_relay';
}
