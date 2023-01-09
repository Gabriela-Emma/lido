<?php

namespace App\Console\Commands;

use App\Jobs\CatalystSyncCompletedReportFromGSheetJob;
use App\Services\SettingService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Revolution\Google\Sheets\Facades\Sheets;

class CatalystSyncCompletedReporting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'ln:ca-cr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Catalyst Completed Reporting.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(SettingService $settingService)
    {
        $sheets = Sheets::spreadsheet($settingService->getSettings()?->catalyst_report_completed_proposals);
        $reportingSheets = collect($sheets->sheetList())->values()->filter(fn ($s) => Str::contains($s, 'COMPLETED'));
        $reportingSheets->each(fn ($sheet) => dispatch(new CatalystSyncCompletedReportFromGSheetJob($sheet)));
    }

    protected function getArguments(): array
    {
        return [
            //            ['model', InputArgument::REQUIRED, 'model type to translate', null],
            //            ['source', InputArgument::OPTIONAL, 'original source lang', 'en'],
            //            ['fields', InputArgument::OPTIONAL, 'space delineated fields on model to translate', null],
        ];
    }

    protected function getOptions(): array
    {
        return [
            //            ['pre-populate', null, InputOption::VALUE_OPTIONAL, 'should we generate', false],
            //            ['publish', null,  InputOption::VALUE_OPTIONAL, 'original source lang', false]
        ];
    }
}
