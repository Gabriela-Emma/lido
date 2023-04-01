<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasAuthor, SoftDeletes, HasFactory;

    public function models(): MorphToMany
    {
        return $this->morphToMany(Giveaway::class, 'model', 'model_wallets', 'model_id', 'wallet_id')
            ->wherePivot('model_type', static::class);
    }
}
