<?php

namespace App\Models\CatalystExplorer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalystRank extends Model
{
    use HasFactory, SoftDeletes;

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'model_id', 'id');
    }
}
