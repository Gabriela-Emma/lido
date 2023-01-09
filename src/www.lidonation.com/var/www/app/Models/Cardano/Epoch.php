<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Epoch extends DbSyncModel
{
    use HasFactory;

    protected $table = 'epoch';
}
