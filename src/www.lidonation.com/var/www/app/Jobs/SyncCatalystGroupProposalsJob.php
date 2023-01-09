<?php

namespace App\Jobs;

use App\Models\CatalystUser;
use App\Models\Proposal;
use App\Repositories\CatalystGroupRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncCatalystGroupProposalsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public int $catalystGroupId
    ) {
    }

    /**
     * Execute the job.
     *
     * @param  CatalystGroupRepository  $catalystGroupRepository
     * @return void
     */
    public function handle(CatalystGroupRepository $catalystGroupRepository): void
    {
        $catalystGroup = $catalystGroupRepository->get($this->catalystGroupId);
        $proposalIds = [];
//        $catalystGroup->proposals_and_challenges()->sync([]);
        $catalystGroup->members()->with('own_proposals_and_challenges.groups')
            ->get()->each(function (CatalystUser $member) use (&$proposalIds) {
                $member->own_proposals_and_challenges->each(function (Proposal $proposal) use (&$proposalIds) {
                    if (! $proposal->groups->isNotEmpty()) {
                        $proposalIds[] = $proposal->id;
                    }
                });
            });
        $catalystGroup->proposals_and_challenges()
            ->syncWithoutDetaching($proposalIds);
    }
}
