<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class ModelLink extends MorphPivot
{
    protected $table = 'model_links';
}
