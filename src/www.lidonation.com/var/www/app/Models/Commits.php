<?php

namespace App\Models;

use Chelout\RelationshipEvents\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commits extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function repo(): BelongsTo
    {
        return $this->belongsTo(Repo::class);
    }
}
