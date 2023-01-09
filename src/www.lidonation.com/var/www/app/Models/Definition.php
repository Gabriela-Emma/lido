<?php

namespace App\Models;

use App\Scopes\OrderByAlphabeticalScope;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Definition extends Model
{
    use HasFactory, SoftDeletes, HasTimestamps;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'date:Y-m-d',
        'published_at' => 'date:Y-m-d',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new PublishedScope);
        static::addGlobalScope(new OrderByAlphabeticalScope);
    }
}
