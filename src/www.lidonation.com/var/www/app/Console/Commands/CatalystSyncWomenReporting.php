<?php

namespace App\Console\Commands;

use App\Jobs\CatalystSyncWomenReportFromGSheetJob;
use App\Models\CatalystExplorer\Fund;
use App\Services\SettingService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Revolution\Google\Sheets\Facades\Sheets;

class CatalystSyncWomenReporting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'ln:ca-wr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Catalyst Woman Proposals.';

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
        $sheets = Sheets::spreadsheet($settingService->getSettings()?->cardano_catalyst_woman_proposals);
        $reportingSheets = collect($sheets->sheetList())->filter(fn ($s) => Str::contains($s, 'Fund'));
        $reportingSheets->each(function ($sheetName, $sheetId) {
            $fundNumber = substr("$sheetName", -1);
            $fund = Fund::where('slug', "fund-{$fundNumber}")->first();
            dispatch(new CatalystSyncWomenReportFromGSheetJob($sheetId, $fund?->id));
        });
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
