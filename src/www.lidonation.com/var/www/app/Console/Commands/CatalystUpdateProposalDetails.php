<?php

namespace App\Console\Commands;

use App\Jobs\CatalystUpdateProposalDetailsJob;
use App\Models\Proposal;
use App\Services\SettingService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class CatalystUpdateProposalDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'ln:ca-proposal-details';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Catalyst Proposal Details from api.';

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
        Proposal::whereRelation('fund.parent', 'id', $this->argument('fund'))->whereNotNull('ideascale_link')->cursor()->each(function ($p) {
            dispatch(new CatalystUpdateProposalDetailsJob($p));
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
