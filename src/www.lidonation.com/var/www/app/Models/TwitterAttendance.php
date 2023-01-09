<?php

namespace App\Models;

use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasMetaData;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TwitterAttendance extends Model implements IHasMetaData
{
    use SoftDeletes, HasAuthor, HasMetaData;

    protected $with = ['metas'];

    public function twitter_event(): BelongsTo
    {
        return $this->belongsTo(TwitterEvent::class);
    }
}
