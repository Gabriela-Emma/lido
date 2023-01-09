<?php

namespace App\Models;

use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasModel;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $with = [];

    use HasFactory,
        HasModel,
        HasMetaData,
        HasTimestamps;
}
