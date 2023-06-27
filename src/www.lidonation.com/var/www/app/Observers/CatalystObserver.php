<?php

namespace App\Observers;

use App\Models\Model;
use App\Models\User;

abstract class CatalystObserver
{
    /**
     * Handle the "deleting" event.
     *
     * @return void
     */
    public function deleting(Model|User $model)
    {
        $model->metas()->delete();
    }
}
