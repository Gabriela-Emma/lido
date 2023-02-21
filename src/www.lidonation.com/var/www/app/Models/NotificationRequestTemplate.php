<?php

namespace App\Models;

use App\Models\Traits\HasMetaData;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class NotificationRequestTemplate extends Model
{
    use Actionable,
        HasMetaData,
        HasTimestamps,
        HasJsonRelationships,
        SoftDeletes;

    protected $casts = [
        'what_filter' => 'json',
        'updated_at' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
    ];
}
