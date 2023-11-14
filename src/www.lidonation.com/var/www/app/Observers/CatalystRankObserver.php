<?php

namespace App\Observers;

use App\Models\CatalystExplorer\CatalystRank;
use App\Models\CatalystExplorer\Proposal;

class CatalystRankObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the CatalystRank "created" event.
     *
     * @return void
     */
    public function created(CatalystRank $catalystRank)
    {
        $this->updateProposalRankTotal($catalystRank);
    }

    /**
     * Handle the CatalystRank "updated" event.
     *
     * @return void
     */
    public function updated(CatalystRank $catalystRank)
    {
        $this->updateProposalRankTotal($catalystRank);
    }

    /**
     * Handle the CatalystRank "deleted" event.
     *
     * @return void
     */
    public function deleted(CatalystRank $catalystRank)
    {
        $this->updateProposalRankTotal($catalystRank);
    }

    /**
     * Handle the CatalystRank "restored" event.
     *
     * @return void
     */
    public function restored(CatalystRank $catalystRank)
    {
        $this->updateProposalRankTotal($catalystRank);
    }

    /**
     * Handle the CatalystRank "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(CatalystRank $catalystRank)
    {
        $this->updateProposalRankTotal($catalystRank);
    }

    protected function updateProposalRankTotal(CatalystRank $rank)
    {
        $total_ranking = CatalystRank::where('model_id', $rank->model_id)
            ->sum('rank');
        $proposal = Proposal::find($rank->model_id);

        // update proposal ranking_total
        $proposal->ranking_total = $total_ranking;
        $proposal->save();
    }
}
