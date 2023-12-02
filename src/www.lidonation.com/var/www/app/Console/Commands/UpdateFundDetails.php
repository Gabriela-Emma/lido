<?php

namespace App\Console\Commands;

use App\Jobs\UpdateFundDetail;
use Illuminate\Console\Command;
use App\Models\CatalystExplorer\Fund;
use Symfony\Component\Console\Input\InputArgument;


class UpdateFundDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:update-fund-details  {fund}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Fund Metas';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Fund::filter(['fund_id' => $this->argument('fund')])
        ->whereHas('metas', function ($query) {
            $query->where('key', 'ideascale_id');
        })->get()->each(function ($challenge) {
            dispatch(new UpdateFundDetail($challenge));
        });
    }


}
