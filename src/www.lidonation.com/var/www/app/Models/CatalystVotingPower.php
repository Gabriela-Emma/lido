<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalystVotingPower extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'voter_id',
        'voting_power',
        'catalyst_snapshot_id',
    ];

    public function catalyst_snapshot()
    {
        return $this->belongsTo(CatalystSnapshot::class, 'catalyst_snapshot_id', 'id');
    }
}
