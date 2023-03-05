<?php

namespace App\Models;

use App\Scopes\LimitScope;
use App\Scopes\OrderByDateScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commit extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime:M d y',
        'created_at' => 'datetime:M d y',
    ];

    public function repo(): BelongsTo
    {
        return $this->belongsTo(Repo::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new OrderByDateScope);
        // if (! app()->runningInConsole()) {
        //     static::addGlobalScope(new LimitScope);
        // }
    }

    public function scopeRemoveLimitScope($query)
    {
        return $query->withoutGlobalScope(LimitScope::class);
        
    }
}
