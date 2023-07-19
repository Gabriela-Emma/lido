<?php

namespace App\Console\Commands;

use App\Jobs\CatalystIdeascaleF10CleanupProposalsJob;
use App\Models\Fund;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class CatalystIdeascaleF10Cleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'ln:ca-cleanup-f10';

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

    public function handle()
    {
        Fund::filter(['fund_id' => $this->argument('fund')])
            ->whereHas('metas', function ($query) {
                $query->where('key', 'ideascale_id');
            })->get()->each(function ($challenge) {
                dispatch_sync(new CatalystIdeascaleF10CleanupProposalsJob($challenge));
            });
    }

    protected function getArguments(): array
    {
        return [
            ['fund', InputArgument::REQUIRED, 'fund to process', null],
        ];
    }
}
