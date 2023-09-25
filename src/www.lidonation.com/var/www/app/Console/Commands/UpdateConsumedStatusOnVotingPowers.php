<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateVotingPowerStatusF10;

class UpdateConsumedStatusOnVotingPowers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:update-voting-powers-consumed-status';

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
    public function handle(): int
    {
        UpdateVotingPowerStatusF10::dispatchSync();
    }
}
