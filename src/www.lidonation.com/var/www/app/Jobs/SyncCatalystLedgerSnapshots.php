<?php

namespace App\Jobs;

use App\Models\Fund;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\CatalystLedgerSnapshot;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SyncCatalystLedgerSnapshots implements ShouldQueue
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
            $response = Http::get('https://archiver.projectcatalyst.io/api/v1/archives');
            $data = $response->json();

            foreach ($data['archives'] as $archive) {
                $fundTitle = $archive['metadata']['fund'];

                // related fund
                $fund = Fund::whereRaw("LOWER(REPLACE(title, ' ', '')) = ?", [strtolower($fundTitle)])->first();
                
                $existingArchive = CatalystLedgerSnapshot::where('snapshot_id', $archive['id'])->first();
                if (!$existingArchive instanceof CatalystLedgerSnapshot) {
                    CatalystLedgerSnapshot::create([
                        'snapshot_id' => $archive['id'],
                        'size' => $archive['size'],
                        'slot' => $archive['metadata']['slot'],
                        'epoch' => $archive['metadata']['epoch'],
                        'fund_id' => $fund?->id,
                        'created_at' => Carbon::parse($archive['metadata']['timestamp']),
                    ]);
                }
            }
    }
}
