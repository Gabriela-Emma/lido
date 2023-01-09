<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Jobs\SyncCatalystGroupProposalsJob;
use App\Models\CatalystGroup;
use App\Models\Post;

class CatalystGroupObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  CatalystGroup  $catalystGroup
     * @return void
     */
    public function creating(CatalystGroup $catalystGroup): void
    {
        (new FillPostData)($catalystGroup);
    }

    /**
     * Handle the User "created" event.
     *
     * @param  CatalystGroup  $catalystGroup
     * @return void
     */
    public function updating(CatalystGroup $catalystGroup): void
    {
//        SyncCatalystGroupProposalsJob::dispatch($catalystGroup->id);
    }

    public function deleting(Post $post): void
    {
        if ($post->forceDeleting) {
            $post->metas()->delete();
        }
    }
}
