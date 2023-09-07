<?php

namespace App\Console\Commands;

use App\Jobs\CatalystIdeascaleF10SyncJob;
use App\Models\Fund;
use App\Services\SettingService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class CatalystIdeascaleF10Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'ln:ca-sync-f10';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Fund 10 proposals from Ideascale';

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
        Fund::filter(['fund_id' => $this->argument('fund')])
            ->whereHas('metas', function ($query) {
                $query->where('key', 'ideascale_id');
            })->get()->each(function ($challenge) {
                dispatch(new CatalystIdeascaleF10SyncJob($challenge));
            });
    }

    protected function getArguments(): array
    {
        return [
            ['fund', InputArgument::REQUIRED, 'fund to process', null],
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
