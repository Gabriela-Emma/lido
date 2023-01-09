<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class ModelSnippet extends MorphPivot
{
    protected $table = 'model_snippets';
}
