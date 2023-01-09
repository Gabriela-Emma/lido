<?php

namespace App\Console\Commands;

use App\Jobs\CatalystSyncFundingReportFromGSheetJob;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Revolution\Google\Sheets\Facades\Sheets;

class CatalystSyncFundingReporting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'ln:ca-fr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Catalyst Funding Reporting.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sheets = Sheets::spreadsheet(config('services.catalyst.catalyst_reporting_spreadsheet_id'));
        $reportingSheets = collect($sheets->sheetList())->values()->filter(fn ($s) => Str::contains($s, 'Reporting'));
        $reportingSheets->each(fn ($sheet) => dispatch(new CatalystSyncFundingReportFromGSheetJob($sheet)));
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
