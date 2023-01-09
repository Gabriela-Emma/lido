<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Artisan;

/**
 * to index run php artisan ln:index 'App\Models\CatalystUser' ln__catalyst_users
 */
class CatalystUserProposal extends Pivot
{
    protected $table = 'catalyst_user_has_proposal';
}
