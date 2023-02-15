<?php

namespace App\Models\Traits;

use App\Models\CatalystUser;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasCatalystProfiles
{
    public function catalyst_profiles(): HasMany
    {
        return $this->hasMany(CatalystUser::class, 'claimed_by');
    }
}
