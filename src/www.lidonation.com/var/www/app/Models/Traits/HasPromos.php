<?php

namespace App\Models\Traits;

use App\Models\Promo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasPromos
{
    public function promos(): HasMany
    {
        return $this->hasMany(Promo::class, 'token_id')->where('token_type', static::class);
    }
}
