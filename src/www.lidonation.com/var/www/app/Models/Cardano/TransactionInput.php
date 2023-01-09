<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionInput extends DbSyncModel
{
    use HasFactory;

    protected $table = 'tx_in';
}
