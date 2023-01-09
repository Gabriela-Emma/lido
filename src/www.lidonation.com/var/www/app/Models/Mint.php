<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Scopes\LimitScope;
use App\Scopes\OrderByDateScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mint extends Model
{
    use HasFactory, HasAuthor;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
    ];

    public function txs(): HasMany
    {
        return $this->hasMany(MintTx::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new OrderByDateScope);
        static::addGlobalScope(new LimitScope);
    }
}
