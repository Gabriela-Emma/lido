<?php

namespace App\Jobs;

use App\Models\CatalystVoter;
use Illuminate\Bus\Queueable;
use App\Models\CatalystVotingPower;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class UpdateVotingPowerStatusF10 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function handle(): void
    {
        CatalystVotingPower::whereRelation('catalyst_snapshot', 'model_id', 113)->orderByDesc('voting_power')->each(
            function ($power) {
                $voter = CatalystVoter::where('cat_id', $power->voter_id)->first();

                if (!$voter instanceof CatalystVoter) {
                    return;
                }
                $filePath = '/data/catalyst-tools/voting-history/f10/' . $voter->stake_pub . '.json';
                if (file_exists($filePath)) {
                    $collection = new Collection(Items::fromFile($filePath));
                    $power->consumed = $collection->isNotEmpty() ? 1 : 0;
                    $power->save();
                }

            }
        );
    }
}
