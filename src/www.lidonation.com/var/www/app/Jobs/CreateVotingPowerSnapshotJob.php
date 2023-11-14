<?php

namespace App\Jobs;

use App\Models\CatalystExplorer\CatalystVotingPower;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\LazyCollection;

class CreateVotingPowerSnapshotJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected LazyCollection $chunk, protected int $snapshotId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->chunk->each(function ($row) {
            if (is_numeric($row[1])) {
                CatalystVotingPower::create([
                    'voter_id' => $row[0],
                    'voting_power' => $row[1],
                    'catalyst_snapshot_id' => $this->snapshotId,
                ]);
            }
        });
    }
}
