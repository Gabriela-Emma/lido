<?php

namespace App\Jobs;

use App\Models\Proposal;
use App\Services\SettingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Revolution\Google\Sheets\Facades\Sheets;

class CatalystSyncImpactReportFromGSheetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public int $sheetId)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(SettingService $settingService): void
    {
        $sheets = Sheets::spreadsheet($settingService->getSettings()?->catalyst_report_impact_proposals);
        ($sheets->sheetById($this->sheetId)->get())?->each(function ($row) {
            // get first data role
            if (! isset($row[9]) || ! filter_var(trim($row[9]), FILTER_VALIDATE_URL)) {
                return true;
            }
            $parts = collect(explode('/', trim($row[9])));

            $ideascaleId = collect(explode('-', $parts->last()))->first();

            // DB::table('proposals')
            $proposal = Proposal::where('ideascale_link', 'like', "%${ideascaleId}-%")->get('id')->first();

            if (! $proposal) {
                return true;
            }

            $proposal->saveMeta('impact_proposal', 1, $proposal);

            return true;
        });
    }
}
