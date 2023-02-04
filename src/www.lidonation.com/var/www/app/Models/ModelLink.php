<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class ModelLink extends MorphPivot
{
    public $timestamps = false;

    protected $table = 'model_links';
}
