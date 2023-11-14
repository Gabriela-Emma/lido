<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Models\CatalystExplorer\Proposal;
use App\Models\Model;
use App\Models\User;

class ProposalObserver extends CatalystObserver
{
    /**
     * Handle the LidoUser "created" event.
     *
     * @return void
     */
    public function creating(Proposal $proposal)
    {
        (new FillPostData)($proposal, [], fn () => [
            'type' => ['type', 'proposal'],
        ]);
    }

    public function deleting(Model|User $model)
    {
        if ($model->isForceDeleting()) {
            parent::deleting($model);
        }
    }
}
