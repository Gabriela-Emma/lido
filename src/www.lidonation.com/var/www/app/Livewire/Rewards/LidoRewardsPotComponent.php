<?php

namespace App\Livewire\Rewards;

use App\Invokables\GetLidoRewardsPot;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LidoRewardsPotComponent extends Component
{
    public $everyEpoch;

    public $rewardsTemplate;

    public $rewardPot;

    public function loadRewards()
    {
        $this->rewardsTemplate = $this->everyEpoch
            ?->giveaway->rules()->where('context', 'reward')
            ->get(['predicate', 'subject'])
            ?->map(fn ($t) => [
                $t->subject => intval($t->predicate),
            ])->collapse()->toArray();

        $this->rewardPot = collect(
            (new GetLidoRewardsPot)($this->everyEpoch)
        )->filter(
            fn ($asset) => isset($this->rewardsTemplate[$asset['asset'].'.amount']) && $asset['amount'] >= $this->rewardsTemplate[$asset['asset'].'.amount']
        );
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.rewards.rewards-pot');
    }
}
