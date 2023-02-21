<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commit extends Model
{
    protected $guarded = [];

    public function repo(): BelongsTo
    {
        return $this->belongsTo(Repo::class);
    }
}
