<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Models\CatalystExplorer\Group;
use App\Models\Post;

class CatalystGroupObserver
{
    /**
     * Handle the LidoUser "created" event.
     */
    public function creating(Group $catalystGroup): void
    {
        (new FillPostData)($catalystGroup);
    }

    /**
     * Handle the LidoUser "created" event.
     */
    public function updating(Group $catalystGroup): void
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
