<?php

namespace App\Models\Reactions;

use Parental\HasChildren;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reaction extends Model
{
    use HasChildren;
    use SoftDeletes;

    protected $table = 'lido_reactions';

    protected $fillable = [
        'model_id',
        'model_type',
        'commenter_type',
        'commenter_id',
        'reaction',
        'type',
    ];

    public function model()
    {
        return $this->morphTo();
    }
}