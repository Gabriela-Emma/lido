<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionMeta extends DbSyncModel
{
    use HasFactory;

    protected $table = 'tx_metadata';
}
