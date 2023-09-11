<?php

namespace App\Models;

use App\Models\Traits\HasModel;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CatalystTally extends Model
{
    use HasModel;

    public $timestamps = false;

    public $casts = [
        'tally' => 'integer',
        'updated_at' => 'datetime'
    ];

    protected $fillable = [
        'hash',
        'tally',
    ];
}
