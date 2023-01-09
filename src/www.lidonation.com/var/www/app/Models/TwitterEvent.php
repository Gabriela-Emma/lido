<?php

namespace App\Models;

use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasMetaData;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TwitterEvent extends Model implements IHasMetaData
{
    use SoftDeletes, HasAuthor, HasMetaData;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'scheduled_at' => 'datetime:M d y',
        'started_at' => 'datetime:M d y',
        'created_at' => 'datetime:M d y',
        'ended_at' => 'datetime:M d y',
    ];

    public function attendances(): HasMany
    {
        return $this->hasMany(TwitterAttendance::class);
    }
}
