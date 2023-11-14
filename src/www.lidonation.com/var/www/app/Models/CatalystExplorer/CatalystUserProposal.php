<?php

namespace App\Models\CatalystExplorer;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * to index run php artisan ln:index 'App\Models\CatalystLidoUser' ln__catalyst_users
 */
class CatalystUserProposal extends Pivot
{
    protected $table = 'catalyst_user_has_proposal';
}
