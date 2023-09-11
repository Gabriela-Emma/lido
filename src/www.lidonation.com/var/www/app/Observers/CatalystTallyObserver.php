<?php

namespace App\Observers;

use App\Models\CatalystTally;

class CatalystTallyObserver
{
    /**
     * Handle the CatalystTally "created" event.
     *
     * @param CatalystTally $catalystTally
     * @return void
     */
    public function created(CatalystTally $catalystTally)
    {
        //
    }

    /**
     * Handle the CatalystTally "updated" event.
     *
     * @param CatalystTally $catalystTally
     * @return void
     */
    public function saving(CatalystTally $catalystTally): void
    {
        $catalystTally->updated_at = now();
    }

    /**
     * Handle the CatalystTally "deleted" event.
     *
     * @param CatalystTally $catalystTally
     * @return void
     */
    public function deleted(CatalystTally $catalystTally)
    {
        //
    }

    /**
     * Handle the CatalystTally "restored" event.
     *
     * @param CatalystTally $catalystTally
     * @return void
     */
    public function restored(CatalystTally $catalystTally)
    {
        //
    }

    /**
     * Handle the CatalystTally "force deleted" event.
     *
     * @param CatalystTally $catalystTally
     * @return void
     */
    public function forceDeleted(CatalystTally $catalystTally)
    {
        //
    }
}
