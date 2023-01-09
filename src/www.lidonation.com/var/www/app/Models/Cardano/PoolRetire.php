<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoolRetire extends DbSyncModel
{
    use HasFactory;

    protected $table = 'pool_retire';

    public function hash(): BelongsTo
    {
        return $this->belongsTo(PoolHash::class, 'hash_id');
    }

    public function announcedTransaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'announced_tx_id');
    }
}
