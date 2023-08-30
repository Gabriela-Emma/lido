<?php

namespace App\Models;

use App\Models\Traits\HasMetaData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CatalystSnapshot extends Model
{
    use HasFactory, HasMetaData;

    public $timestamps = false;

    protected $fillable = [
        'model_id',
        'model_type',
        'epoch',
        'order',
        'snapshot_at',
    ];

    protected $casts = [
        'snapshot_at' => 'datetime:Y-m-d',
    ];

    public function model(): MorphTo
    {
        return $this->morphTo('model', 'model_type', 'model_id');
    }

    public function votingPowers()
    {
        return $this->hasMany(CatalystVotingPower::class, 'catalyst_snapshot_id', 'id');
    }
}
