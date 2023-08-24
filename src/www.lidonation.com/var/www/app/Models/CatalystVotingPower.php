<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalystVotingPower extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'stake_pub',
        'voting_power',
        'catalyst_snapshot_id',
    ];
}
