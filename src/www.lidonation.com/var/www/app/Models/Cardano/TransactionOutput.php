<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionOutput extends DbSyncModel
{
    use HasFactory;

    protected $table = 'tx_out';
}
