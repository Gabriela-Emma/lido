<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Models\Proposal;

class ProposalObserver extends CatalystObserver
{

    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function creating(Proposal $proposal)
    {
        (new FillPostData)($proposal, [], fn () => [
            'type' => ['type', 'proposal'],
        ]);
    }
}
