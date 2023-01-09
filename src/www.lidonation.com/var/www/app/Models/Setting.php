<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    protected $fillable = ['key', 'value'];

    /**
     * Specify the amount of time to cache queries.
     * Do not specify or set it to null to disable caching.
     *
     * @var int|DateTime|null
     */
    public int|DateTime|null $cacheFor = 10800;

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static bool $flushCacheOnUpdate = true;

    protected $casts = [
        'value' => 'json',
    ];
}
