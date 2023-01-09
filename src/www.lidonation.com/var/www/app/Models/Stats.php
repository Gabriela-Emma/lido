<?php

namespace App\Models;

use App\Models\Traits\HasTranslations;

class Stats extends Model
{
    use HasTranslations;

    protected $fillable = ['label', 'key', 'value'];

    public $translatable = [
        'label',
    ];
}
