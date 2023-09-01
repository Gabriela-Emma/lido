<?php

namespace App\Jobs;

use App\Models\CatalystRegistration;
use App\Models\CatalystSnapshot;
use App\Models\CatalystVotingPower;
use App\Services\CardanoBlockfrostService;
use App\Services\SyncCatalystSnapshotService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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

            $fundSnapshots = CatalystSnapshot::where('model_type', App\Model\Fund::class)
                ->get();

            foreach ($fundSnapshots as $snapshot) {
                $registeredStakePub = CatalystRegistration::where('created_at', '<', $snapshot->snapshot_at)
                    ->pluck('stake_pub')
                    ->unique();

                foreach($registeredStakePub as $stakeAddress) {
                    dispatch(new SyncCatalystVotingPowersJob($snapshot, $stakeAddress));
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
                ->get("accounts/stake1ux0tpffwmyv802r9m4zzxvpkthm86nr9jzjm5cpwcxg33qs49rnrc/history", null)
                ->collect();

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
        }
    }
}
