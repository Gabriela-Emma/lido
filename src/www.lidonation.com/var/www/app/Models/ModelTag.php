<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class ModelTag extends MorphPivot
{
    protected $table = 'model_tags';
}
