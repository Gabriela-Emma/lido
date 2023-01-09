<?php

namespace App\Models\Cardano;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DbSyncModel extends Model
{
    use HasFactory;

    protected $connection = 'pgsqlDbSync';

    const CREATED_AT = 'start_time';

    const UPDATED_AT = null;
}
