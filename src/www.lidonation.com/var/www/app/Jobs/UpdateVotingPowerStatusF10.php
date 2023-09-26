<?php

namespace App\Jobs;

use App\Models\CatalystVoter;
use Illuminate\Bus\Queueable;
use App\Models\CatalystVotingPower;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateVotingPowerStatusF10 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        CatalystVotingPower::whereRelation('catalyst_snapshot', 'model_id', 113)->each(
            function ($power) {
                $voter = CatalystVoter::where('cat_id', $power->voter_id)->first();

                if ($voter instanceof CatalystVoter) {
                    $power->consumed = 1;
                } else {
                    $power->consumed = 0;
                }
                $power->save();
            }
        );
    }
}
