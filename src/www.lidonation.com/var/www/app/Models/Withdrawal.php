<?php

namespace App\Models;

use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTxs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Withdrawal extends Model implements IHasMetaData
{
    use HasTxs, HasMetaData, HasAuthor;

    protected $with = ['txs'];

    protected $withCount = ['txs'];

    /**
     * Scope a query to only include popular users.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', '=', 'pending');
    }

    public function amounts(): Attribute
    {
        return Attribute::make(get: function ($value) {
            return $this->rewards->groupBy('asset')->values;
        });
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeValidated(Builder $query): Builder
    {
        return $query->where('status', '=', 'validated');
    }

    public function rewards(): HasMany
    {
        return $this->hasMany(Reward::class, 'withdrawal_id');
    }
}
