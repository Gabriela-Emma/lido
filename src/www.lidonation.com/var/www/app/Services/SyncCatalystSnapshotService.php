<?php

namespace App\Services;

use App\Models\CatalystSnapshot;
use App\Models\Fund;
use Carbon\Carbon;
use JsonMachine\Items;

class SyncCatalystSnapshotService
{
    public function __construct()
    {}

    public function syncCatalystSnapshot()
    {
        $VPSDates = Items::fromFile(storage_path().'/json/voting-powers-snapshot-dates.json');

        foreach ($VPSDates as $date) {
            $slug = 'fund-'.$date->fund;
            $fund = Fund::where('slug', $slug)
                ->first();
                    
            if ($fund instanceof Fund) {
                $snapshot_at = Carbon::parse($date->date);
                $epoch = $this->dateToEpoch($snapshot_at);

                
                try {
                    $existingSnapshot = CatalystSnapshot::where('order', $date->fund)
                        ->first();

                    if ($existingSnapshot instanceof CatalystSnapshot) {
                        
                        $existingSnapshot->model_id = $fund->id;
                        $existingSnapshot->model_type = Fund::class;
                        $existingSnapshot->epoch = $epoch;
                        $existingSnapshot->order = $date->fund;
                        $existingSnapshot->snapshot_at = $snapshot_at;

                        $existingSnapshot->save();
                    } else {
                        CatalystSnapshot::firstOrCreate([
                            "model_id" => $fund->id,
                            "model_type" => Fund::class,
                            "epoch" => $epoch,
                            "order" => $date->fund,
                            "snapshot_at" => $snapshot_at,
                        ]);
                    }
                } catch (\Throwable $th) {
                    continue;
                }
            }
        }
    }

    protected function dateToEpoch(Carbon $snapshot_at)
    {
        $poxisSnapshotAt = $snapshot_at->timestamp;
        $epoch = ceil(($poxisSnapshotAt - 1506203091) / 432000);
        
        return $epoch;
    }
}