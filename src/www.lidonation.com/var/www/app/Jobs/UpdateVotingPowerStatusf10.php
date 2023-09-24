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

class UpdateVotingPowerStatusf10 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        CatalystVotingPower::whereRelation('catalyst_snapshot.model', 'id', 113)->each(
            function($power){
                // dd($power);
                $voter = CatalystVoter::where('cat_id',$power->voter_id)->first();
                if($voter instanceof CatalystVoter &&  file_exists('/data/catalyst-tools/voting-history/f10/' . $voter->stake_pub . '.json')){
                    $power->consumed = 1;
                    $power->save();
                }else{
                    $power->consumed = 0;
                    $power->save();
                }
            }
        );
    }
}
