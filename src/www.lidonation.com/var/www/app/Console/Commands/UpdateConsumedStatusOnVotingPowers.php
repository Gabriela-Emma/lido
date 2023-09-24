<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateVotingPowerStatusf10;

class UpdateConsumedStatusOnVotingPowers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:updateVotingPowers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update voting powers consumed status';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        UpdateVotingPowerStatusf10::dispatchSync();
    }
}
