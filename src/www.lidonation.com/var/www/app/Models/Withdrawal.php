<?php

namespace App\Models;

use App\DataTransferObjects\RewardData;
use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasMetaData;
use App\Models\Traits\HasTxs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\LaravelData\DataCollection;

class Withdrawal extends Model implements IHasMetaData
{
    use HasAuthor, HasFactory, HasMetaData, HasTxs;

    protected $with = ['txs'];

    protected $withCount = ['txs'];

    protected $appends = ['withdrawal_tx'];

    protected $casts = [
        //        'rewards' => DataCollection::class.':'.RewardData::class,
    ];

    public function withdrawalTx(): Attribute
    {
        return Attribute::make(get: function ($value) {
            return $this->metas->where('key', '=', 'withdrawal_tx')->first()?->content;
        });
    }

    /**
     * Scope a query to only include popular users.
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
