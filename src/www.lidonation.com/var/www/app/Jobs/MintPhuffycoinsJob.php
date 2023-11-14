<?php

namespace App\Jobs;

use App\Models\User;
use App\Repositories\EpochRepository;
use App\Services\PhuffycoinService;
use App\Services\Traits\DbSyncHelpers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Fluent;

class MintPhuffycoinsJob implements ShouldQueue
{
    use DbSyncHelpers, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected PhuffycoinService $phuffycoinService;

    protected EpochRepository $epochRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public $args = [])
    {
        $this->args = new Fluent(array_merge([
            'type' => null,
            'pool' => null,
            'address' => null,
            'epoch' => null,
            'memo' => null,
            'depositAddress' => null,
        ], $this->args));
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function handle(PhuffycoinService $phuffycoinService, EpochRepository $epochRepository)
    {
        if (! isset($this->args->epoch)) {
            $this->args->epoch = $epochRepository->current()?->no;
        }

        $this->phuffycoinService = $phuffycoinService;
        $this->epochRepository = $epochRepository;
        // validate deposit and get mint amount

        $this->processLidoUsers();
    }

    protected function getMintAmount()
    {
        $amount = null;
    }

    protected function processLidoUsers()
    {
        // get all user with a stake address
        $users = User::whereNotNull('wallet_stake_address')->limit(User::count())->cursor();
        foreach ($users as $user) {
            $score = $this->phuffycoinService->getUserEpochCohortScore($user, $this->args->epoch);
        }
    }
}
