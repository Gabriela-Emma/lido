<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

class Commitment extends Model
{
    protected $fillable = [
        'user_id', 
        'lang',
        'model_id',
        'model_class',
    ];

    public function model(): MorphTo
    {
        return $this->morphTo('model', 'model_class', 'model_id');
    }

    
}
