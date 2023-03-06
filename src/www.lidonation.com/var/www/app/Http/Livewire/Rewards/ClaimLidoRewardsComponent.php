<?php

namespace App\Http\Livewire\Rewards;

use App\Invokables\GetLidoRewardsPot;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ClaimLidoRewardsComponent extends Component
{
    public $everyEpoch;

    public $rewardPot;

    public $rewardsTemplate;

    /**
     */
    public function loadRewards()
    {
        $this->rewardPot = collect(
            (new GetLidoRewardsPot)($this->everyEpoch)
        )->filter(
            fn ($asset) => $asset['amount'] >= $this->rewardsTemplate[$asset['asset'].'.amount']
        );
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.rewards.claim-rewards');
    }
}
