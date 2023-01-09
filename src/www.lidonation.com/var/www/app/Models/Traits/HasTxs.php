<?php

namespace App\Models\Traits;

use App\Models\Tx;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasTxs
{
    public function txs(): HasMany
    {
        return $this->hasMany(Tx::class, 'model_id')->where('model_type', static::class);
    }
}
