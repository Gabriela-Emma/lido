<?php

namespace App\Models\Interfaces;

use Illuminate\Database\Eloquent\Casts\Attribute;

interface HasLink
{
    public function link(): Attribute;
}
