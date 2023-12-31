<?php

namespace App\Console\Commands;

use App\Jobs\UpdateVotingPowerStatusF10;
use Illuminate\Console\Command;

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
     */
    public function handle(): void
    {
        UpdateVotingPowerStatusF10::dispatchSync();
    }
}
