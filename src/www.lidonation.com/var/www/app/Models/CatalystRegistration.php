<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatalystRegistration extends Model
{
    use HasFactory;

    protected $with = ['delegators'];

    public function delegators(): HasMany
    {
        return $this->hasMany(Delegation::class, 'catalyst_registration_id');
    }
}
