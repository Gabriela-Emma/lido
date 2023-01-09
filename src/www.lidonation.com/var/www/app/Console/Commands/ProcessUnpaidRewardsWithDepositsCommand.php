<?php

namespace App\Console\Commands;

use App\Jobs\ProcessUnpaidRewardsWithDepositsJob;
use Illuminate\Console\Command;

class ProcessUnpaidRewardsWithDepositsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:payout-deposits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually pay out rewards with dust deposits';

    public function handle()
    {
        // @todo move this to environment variable.
        ProcessUnpaidRewardsWithDepositsJob::dispatch('addr1qx26t5tt546x30quz3dmzh2vk0k7zcztgw9pskeeqd4tsmrl904t4hkpvwfysl8etmqunfry7r7f76k90ravmu4fu9pq9m55vr');
    }
}
