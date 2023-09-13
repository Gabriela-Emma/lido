<?php

namespace App\Observers;

use App\Models\CatalystTally;

class CatalystTallyObserver
{
    /**
     * Handle the CatalystTally "created" event.
     *
     * @return void
     */
    public function created(CatalystTally $catalystTally)
    {
        //
    }

    /**
     * Handle the CatalystTally "updated" event.
     */
    public function saving(CatalystTally $catalystTally): void
    {
        $catalystTally->updated_at = now();
    }

    /**
     * Handle the CatalystTally "deleted" event.
     *
     * @return void
     */
    public function deleted(CatalystTally $catalystTally)
    {
        //
    }

    /**
     * Handle the CatalystTally "restored" event.
     *
     * @return void
     */
    public function restored(CatalystTally $catalystTally)
    {
        //
    }

    /**
     * Handle the CatalystTally "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(CatalystTally $catalystTally)
    {
        //
    }
}
