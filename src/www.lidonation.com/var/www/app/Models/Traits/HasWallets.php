<?php

namespace App\Models\Traits;

use App\Models\ModelWallet;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasWallets
{
    public function wallets(): BelongsToMany
    {
        return $this->belongsToMany(Wallet::class, ModelWallet::class, 'model_id', 'wallet_id')
            ->where('model_type', static::class)
            ->withPivot('model_type');
    }
}
