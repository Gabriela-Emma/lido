<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PoolMeta extends DbSyncModel
{
    use HasFactory;

    protected $table = 'pool_metadata_ref';
}
