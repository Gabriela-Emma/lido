<?php

namespace App\Console\Commands;

use App\Jobs\CatalystMonthlyReportJob;
use App\Services\SettingService;
use Illuminate\Console\Command;

class CatalystSyncMonthlyReporting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'ln:ca-monthly-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Catalyst Monthly Reporting.';

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
        dispatch(new CatalystMonthlyReportJob());
    }

    protected function getArguments(): array
    {
        return [
            //            ['source', InputArgument::OPTIONAL, 'original source lang', 'en'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            //            ['publish', null,  InputOption::VALUE_OPTIONAL, 'original source lang', false]
        ];
    }
}
