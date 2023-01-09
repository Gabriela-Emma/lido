<?php

namespace App\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface HasRewardsContract
{
    public function rewards(): HasMany;
}
