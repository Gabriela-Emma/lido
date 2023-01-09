<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends DbSyncModel
{
    use HasFactory;

    protected $table = 'tx';

    public function inputs(): HasMany
    {
        return $this->hasMany(TransactionInput::class, 'tx_in_id');
    }

    public function outputs(): HasMany
    {
        return $this->hasMany(TransactionOutput::class, 'tx_id');
    }
}
