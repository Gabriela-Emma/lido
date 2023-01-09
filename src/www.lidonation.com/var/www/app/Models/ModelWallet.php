<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class ModelWallet extends MorphPivot
{
    protected $table = 'model_wallets';
}
