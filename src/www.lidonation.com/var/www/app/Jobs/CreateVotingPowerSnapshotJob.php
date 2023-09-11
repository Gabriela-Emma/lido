<?php

namespace App\Jobs;

use App\Models\CatalystVotingPower;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateVotingPowerSnapshotJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $snapshot, protected $stake_address, protected $voting_power)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        CatalystVotingPower::create([
            'stake_pub' => $this->stake_address,
            'voting_power' => $this->voting_power,
            'catalyst_snapshot_id' => $this->snapshot->id,
        ]);
    }
    
}
