<?php

namespace App\Models;

use App\Models\Interfaces\IHasMetaData;
use App\Models\Traits\HasMetaData;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MintTx extends Model implements IHasMetaData
{
    use HasMetaData;

    protected $with = ['mint'];

    public function getAmountFormattedAttribute()
    {
        if (! isset($this->amount)) {
            return $this->amount;
        }

        return '₳ '.number_format($this->amount, 0, '.', ',');
    }

    public function getEpochDelegationAmountFormattedAttribute(): ?string
    {
        if (! isset($this->meta_data?->epoch_delegation_amount)) {
            return $this->meta_data?->epoch_delegation_amount;
        }

        return '₳ '.number_format($this->meta_data?->epoch_delegation_amount / 1000000, 0, '.', ',');
    }

    public function mint(): BelongsTo
    {
        return $this->belongsTo(Mint::class);
    }

    public function delegator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
