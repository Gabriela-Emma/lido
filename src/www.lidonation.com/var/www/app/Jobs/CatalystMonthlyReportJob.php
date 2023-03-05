<?php

namespace App\Jobs;

use App\Models\CatalystReport;
use App\Models\Proposal;
use App\Services\SettingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Revolution\Google\Sheets\Facades\Sheets;

class CatalystMonthlyReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(SettingService $settingService): void
    {
        $sheets = Sheets::spreadsheet($settingService->getSettings()?->catalyst_report_monthly_report);
        collect($sheets->sheetList())->each(function ($sheetName) use ($sheets, $settingService) {
            $sheet = $sheets->sheet($sheetName)?->get();
            $sheet->skip($settingService->getSettings()?->catalyst_report_monthly_report_skips ?? 0)
                ->each(function ($row) {
                    // get first data role
                    if (! isset($row[0]) || intval($row[0]) <= 0) {
                        return true;
                    }
                    $iogHash = $row[0];
                    $proposal = Proposal::whereHas('metas', fn ($q) => $q->where([
                        'key' => 'iog_hash',
                        'content' => $iogHash,
                    ]))->first();

                    if (! $proposal instanceof Proposal) {
                        return true;
                    }

                    $catalystReport = new CatalystReport;
                    $catalystReport->proposal_id = $proposal->id;

                    if (isset($row[12])) {
                        $catalystReport->content = $row[12];
                    }
                    if (isset($row[8])) {
                        $catalystReport->on_track = $row[8];
                    }
                    if (isset($row[11])) {
                        $catalystReport->attachment = $row[11];
                    }
                    if (isset($row[15])) {
                        $catalystReport->token_utility = $row[15];
                    }
                    if (isset($row[14])) {
                        $catalystReport->community_size = $row[14];
                    }
                    if (isset($row[7])) {
                        $catalystReport->project_status = $row[7];
                    }
                    if (isset($row[18])) {
                        $catalystReport->circle_feedback = $row[18];
                    }
                    if (isset($row[13])) {
                        $catalystReport->token_launching = $row[13];
                    }
                    if (isset($row[9])) {
                        $catalystReport->off_track_reason = $row[9];
                    }
                    if (isset($row[10])) {
                        $catalystReport->completion_target = $row[10];
                    }
                    $catalystReport->save();

                    return true;
                });
            $settingService->saveSetting('catalyst_report_monthly_report_skips', $sheet->count());
        });
    }
}
