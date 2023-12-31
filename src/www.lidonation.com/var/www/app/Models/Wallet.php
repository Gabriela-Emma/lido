<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\CatalystExplorer\VoterHistory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Wallet extends Model
{
    use HasAuthor, HasFactory, SoftDeletes;

    public function models(): MorphToMany
    {
        return $this->morphToMany(Giveaway::class, 'model', 'model_wallets', 'model_id', 'wallet_id')
            ->wherePivot('model_type', static::class);
    }

}
