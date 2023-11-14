<?php

namespace App\Models\CatalystExplorer;

use App\Models\Model;
use App\Models\Traits\HasModel;

class CatalystTally extends Model
{
    use HasModel;

    public $timestamps = false;

    public $casts = [
        'tally' => 'integer',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'hash',
        'tally',
    ];

    public function proposal()
    {
        return $this->hasOne(Proposal::class, 'id', 'model_id');
    }
}
