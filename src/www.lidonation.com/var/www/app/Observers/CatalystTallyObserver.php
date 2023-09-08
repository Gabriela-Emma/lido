<?php

namespace App\Observers;

use App\Models\CatalystTally;

class CatalystTallyObserver
{
    /**
     * Handle the CatalystTally "created" event.
     *
     * @param  \App\Models\CatalystTally  $catalystTally
     * @return void
     */
    public function created(CatalystTally $catalystTally)
    {
        //
    }

    /**
     * Handle the CatalystTally "updated" event.
     *
     * @param  \App\Models\CatalystTally  $catalystTally
     * @return void
     */
    public function updated(CatalystTally $catalystTally)
    {
        if ($catalystTally->isDirty(['tally'])) {
            $catalystTally->updated_at = now();
        }
    }

    /**
     * Handle the CatalystTally "deleted" event.
     *
     * @param  \App\Models\CatalystTally  $catalystTally
     * @return void
     */
    public function deleted(CatalystTally $catalystTally)
    {
        //
    }

    /**
     * Handle the CatalystTally "restored" event.
     *
     * @param  \App\Models\CatalystTally  $catalystTally
     * @return void
     */
    public function restored(CatalystTally $catalystTally)
    {
        //
    }

    /**
     * Handle the CatalystTally "force deleted" event.
     *
     * @param  \App\Models\CatalystTally  $catalystTally
     * @return void
     */
    public function forceDeleted(CatalystTally $catalystTally)
    {
        //
    }
}
