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

class CatalystSyncWomenReportFromGSheetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public int $sheetId, public int $fundId)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(SettingService $settingService): void
    {
        $sheets = Sheets::spreadsheet($settingService->getSettings()?->cardano_catalyst_woman_proposals);
        ($sheets->sheetById($this->sheetId)->get())?->each(function ($row) {
            // get first data role
            if (! isset($row[3]) || ! filter_var(trim($row[3]), FILTER_VALIDATE_URL)) {
                return true;
            }

            $parts = collect(explode('/', trim($row[3])));

            $slug = $parts->last();
            $proposal = Proposal::where('slug', 'like', "{$slug}%")->whereRelation('fund.parent', 'id', $this->fundId)->first();
            if (! $proposal) {
                return true;
            }

            $proposal->saveMeta('woman_proposal', 1, $proposal);

            return true;
        });
    }
}
