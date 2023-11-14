<?php

namespace App\Jobs;

use App\Models\CatalystExplorer\CatalystVoter;
use App\Models\CatalystExplorer\CatalystVotingPower;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class UpdateVotingPowerStatusF10 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @throws InvalidArgumentException
     */
    public function handle(): void
    {
        CatalystVotingPower::whereRelation('catalyst_snapshot', 'model_id', 113)->orderByDesc('voting_power')->each(
            function ($power) {
                $voter = CatalystVoter::where('cat_id', $power->voter_id)->first();

                if (! $voter instanceof CatalystVoter) {
                    return;
                }
                $filePath = '/data/catalyst-tools/voting-history/f10/'.$voter->stake_pub.'.json';
                if (file_exists($filePath)) {
                    $collection = new Collection(Items::fromFile($filePath));
                    $power->consumed = $collection->isNotEmpty() ? 1 : 0;
                    $power->votes_cast = $collection->count();
                    $power->save();
                }

            }
        );
    }
}
