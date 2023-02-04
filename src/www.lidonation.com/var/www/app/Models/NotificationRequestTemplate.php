<?php

namespace App\Models;

use App\Models\Traits\HasMetaData;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class NotificationRequestTemplate extends Model
{
    use Actionable,
        HasMetaData,
        HasTimestamps,
        SoftDeletes;

    protected $casts = [
        'what_filter' => 'array',
        'updated_at' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
    ];
}
