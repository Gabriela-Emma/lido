<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SlotLeader extends DbSyncModel
{
    use HasFactory;

    protected $table = 'slot_leader';
}
