<?php

namespace App\Jobs;

use App\Models\CatalystRegistration;
use App\Models\CatalystSnapshot;
use App\Models\CatalystVotingPower;
use App\Models\Fund;
use App\Services\CardanoBlockfrostService;
use App\Services\SyncCatalystSnapshotService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncCatalystVotingPowersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected $snapshot = null, protected $stakeAddress = null)
    {
        if (is_null($this->snapshot) && is_null($this->stakeAddress)) {
            (new SyncCatalystSnapshotService)->syncCatalystSnapshot(); //sync Catalyst Snapshots
    
            $fundSnapshots = CatalystSnapshot::where('model_type', Fund::class)
                ->get();
    
            foreach ($fundSnapshots as $snapshot) {
                $registeredStakePub = CatalystRegistration::where('created_at', '<', $snapshot->snapshot_at)
                    ->pluck('stake_pub')
                    ->unique();
    
                foreach($registeredStakePub as $stakeAddress) {
                    dispatch(new self($snapshot, $stakeAddress));
                }
            }
        }

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!is_null($this->snapshot) && !is_null($this->stakeAddress)) {
            $accountHistory = app(CardanoBlockfrostService::class)
                ->get("accounts/{$this->stakeAddress}/history", null)
                ->collect();
            
            try {
                $accountEpochDetails = $accountHistory->filter(function($record) {
                        if($record["active_epoch"] == $this->snapshot->epoch) {
                                return $record;
                        }
                    })
                    ->first();
                
                if (!is_null($accountEpochDetails)) {
                    CatalystVotingPower::firstOrCreate([
                        "stake_pub" => $this->stakeAddress,
                        "voting_power" => $accountEpochDetails['amount'],
                        "catalyst_snapshot_id" => $this->snapshot->id,
                    ]);
                }
            } catch (\Throwable $th) {
                
            }
        }
    }
}
