<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Block extends DbSyncModel
{
    use HasFactory;

    protected $table = 'block';
}
