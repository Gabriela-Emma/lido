<?php

namespace App\Models\Reactions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parental\HasChildren;

class Reaction extends Model
{
    use HasChildren;
    use SoftDeletes;
    use HasFactory;

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
