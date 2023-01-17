<?php

namespace App\Http\Livewire\Rewards;

use App\Invokables\GetPoolMultiplier;
use App\Models\Giveaway;
use App\Models\Reward;
use App\Models\User;
use App\Repositories\PostRepository;
use App\Services\CardanoBlockfrostService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Fluent;
use Livewire\Component;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class LidoRewardsComponent extends Component
{
    public $epoch;

    public $everyEpoch;

    public $everyEpochQuiz;

    public $everyEpochQuestion;

    public $partnerPromo;

    public $rewardPot;

    public $rewardsTemplate;

    public $availableRewards;

    public $withdrawalsProcessed;

    public $withdrawals;

    public $myResponse;

    protected $listeners = [
        'claimEveryEpochReward' => 'claimEveryEpochReward',
    ];

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function mount(PostRepository $posts)
    {
        $user = auth()?->user();
        // get epoch
        $this->epoch = app(CardanoBlockfrostService::class)->get('epochs/latest/', null)->collect();
        $this->availableRewards = Reward::where('stake_address', $user?->wallet_stake_address)
            ->where('status', 'issued')
            ->orderBy('created_at', 'desc')
            ->get();

        $this->withdrawals = $user?->withdrawals;

        $this->withdrawalsProcessed = Reward::where('stake_address', $user?->wallet_stake_address)
            ->where('status', 'processed')
            ->orderBy('created_at', 'desc')
            ->get()
            ?->groupBy('asset')
            ->map(function ($group) {
                $asset = new Fluent(
                    array_merge(
                        $group[0]?->toArray() ?? [],
                        [
                            'amount' => collect($group)->sum('amount'),
                            'memo' => "Withdrawals processed {$group[0]?->updated_at->diffForHumans()}",
                            'processed_at' => $group[0]?->updated_at->diffForHumans(),
                        ]
                    ));
                if (is_array($asset->asset_details)) {
                    $asset->asset_details = new Fluent($asset->asset_details);
                }

                return $asset;
            })->values() ?? [];
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.rewards.app')
            ->layout(
                'livewire.rewards.layout',
                [
                    'metaTitle' => 'Lido Rewards Portal',
                ]
            )->withShortcodes();
    }

    protected function saveReward($reward, $user)
    {
        $multiplier = (new GetPoolMultiplier)($user);

        // apply multiplier
        $reward->amount = $reward->amount * $multiplier;
        $reward->setTranslation(
            'memo', 'en',
            "{$this->everyEpoch->title} reward".($multiplier > 1 ? ' with Multiplier' : '')
        );
        $reward->save();
    }

    protected function issueReward(string $asset)
    {
        $user = auth()->user();
        $amount = $this->rewardsTemplate[$asset.'.amount'];
        $reward = new Reward;
        $reward->user_id = $user->id;
        $reward->asset = $asset;
        $reward->model_id = $this->everyEpoch?->giveaway->id;
        $reward->model_type = Giveaway::class;
        $reward->asset_type = 'ft';
        $reward->amount = $amount;
        $reward->status = 'issued';
        $reward->stake_address = $user->wallet_stake_address;

        return $reward;
    }

    protected function dispatchErrors()
    {
        foreach ($this->getErrorBag()?->getMessages() as $name => $msg) {
            $this->dispatchBrowserEvent('new-notice', [
                'type' => 'error',
                'name' => $name,
                'message' => $msg,
            ]);
        }
    }

    protected function loadLidoRewards(User $user)
    {
        $this->availableRewards = Reward::where('stake_address', $user?->wallet_stake_address)
            ->where('status', 'issued')
            ->orderBy('created_at', 'desc')
            ->get();

        $this->withdrawalsProcessed = Reward::where('stake_address', auth()?->user()?->wallet_stake_address)
            ->where('status', 'processed')
            ->orderBy('created_at', 'desc')
            ->get()
            ?->groupBy('asset')
            ->map(function ($group) {
                $asset = new Fluent(
                    array_merge(
                        $group[0]?->toArray() ?? [],
                        [
                            'amount' => collect($group)->sum('amount'),
                            'memo' => "Withdrawals processed {$group[0]?->updated_at->diffForHumans()}",
                            'processed_at' => $group[0]?->updated_at->diffForHumans(),
                        ]
                    ));
                if (is_array($asset->asset_details)) {
                    $asset->asset_details = new Fluent($asset->asset_details);
                }

                return $asset;
            })->values() ?? [];

        $this->dispatchBrowserEvent('lido-rewards-loaded');
    }
}
