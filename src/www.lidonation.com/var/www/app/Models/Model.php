<?php

namespace App\Models;

use App\Traits\HasRemovableGlobalScopes;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;

//use Rennokki\QueryCache\Traits\QueryCacheable;

class Model extends EloquentModel
{
    use HasRemovableGlobalScopes, HasFactory;
    //, QueryCacheable;

    /**
     * Specify the amount of time to cache queries.
     * Do not specify or set it to null to disable caching.
     */
    public int|DateTime|null $cacheFor = null;

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     */
    protected static bool $flushCacheOnUpdate = true;

    /**
     * Specify the amount of time to cache queries.
     * Set it to null to disable caching.
     */
    protected function cacheForValue(): DateTime|int|null
    {
        //        if (optional(request()->user())->hasRole('admin')) {
        //            return null;
        //        }

        return $this->cacheFor;
    }
}
