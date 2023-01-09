<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasModel;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Tx extends Model
{
    use HasModel, HasAuthor;

    protected $hidden = ['user_id', 'deleted_at', 'model_type', 'model_id', 'media'];

    protected $casts = [
        'metadata' => AsArrayObject::class,
        'updated_at' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
        'minted_at' => 'datetime:Y-m-d'
    ];
}
