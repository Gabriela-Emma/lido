<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delegation extends DbSyncModel
{
    use HasFactory;

    protected $table = 'delegation';

    public function poolHash(): BelongsTo
    {
        return $this->belongsTo(PoolHash::class);
    }
}
