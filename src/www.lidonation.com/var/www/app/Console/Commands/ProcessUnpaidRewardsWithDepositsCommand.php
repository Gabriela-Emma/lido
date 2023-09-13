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

        $metas = \App\Models\Meta::where('key', 'quickpitch')
            ->orderBy('model_id')
            ->get();

        foreach ($metas as $meta) {
            $proposal = \App\Models\Proposal::find($meta->model_id);
            if ($proposal) {
                $proposal->quickpitch = $meta->content;
                $proposal->save();
                \App\Jobs\ProposalQuickPitchLength::dispatchSync($proposal);
            }
        }
        // @todo move this to environment variable.
        ProcessUnpaidRewardsWithDepositsJob::dispatch('addr1qx26t5tt546x30quz3dmzh2vk0k7zcztgw9pskeeqd4tsmrl904t4hkpvwfysl8etmqunfry7r7f76k90ravmu4fu9pq9m55vr');
    }
}
