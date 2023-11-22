<?php

namespace App\Models\Reactions;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parental\HasChildren;

class Reaction extends Model
{
    use HasChildren, SoftDeletes;

    protected $table = 'lido_reactions';

    protected $fillable = [
        'model_id',
        'model_type',
        'commenter_type',
        'commenter_id',
        'reaction',
        'type',
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
