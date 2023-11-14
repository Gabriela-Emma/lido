<?php

namespace App\Models;

use App\Models\CatalystExplorer\CatalystRegistration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delegation extends Model
{
    use HasFactory;

    public function catalystRegistration(): BelongsTo
    {
        return $this->belongsTo(CatalystRegistration::class, 'catalyst_registration_id');
    }
}
