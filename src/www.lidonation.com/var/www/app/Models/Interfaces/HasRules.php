<?php

namespace App\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface HasRules
{
    public function rules(): HasMany;
}
