<?php

namespace App\Console\Commands;

use App\Jobs\CatalystSyncImpactReportFromGSheetJob;
use App\Services\SettingService;
use Illuminate\Console\Command;
use Revolution\Google\Sheets\Facades\Sheets;

class CatalystSyncImpactReporting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'ln:ca-ir';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Catalyst Impact Reporting.';

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
        $sheets = Sheets::spreadsheet($settingService->getSettings()?->catalyst_report_impact_proposals);
        $sheet = (int) collect($sheets->sheetList())->keys()->first() ?? null;
        dispatch(new CatalystSyncImpactReportFromGSheetJob($sheet));
    }

    protected function getArguments(): array
    {
        return [
            //            ['model', InputArgument::REQUIRED, 'model type to translate', null],
            //            ['source', InputArgument::OPTIONAL, 'original source lang', 'en'],
            //            ['fields', InputArgument::OPTIONAL, 'space delineated fields on model to translate', null],
            //            ['targets', InputArgument::OPTIONAL, 'languages to translate to', null]
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
