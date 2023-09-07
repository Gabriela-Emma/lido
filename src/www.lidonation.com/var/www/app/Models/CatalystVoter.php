<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CatalystVoter extends Model
{
    protected $table = '_catalyst_voters';

    protected $with = [];

    protected $appends = ['registrations'];

    public function registrations()
    {
        return CatalystRegistration::where('stake_pub', $this->stake_pub)
                ->where('stake_key', $this->stake_key);
    }
}
