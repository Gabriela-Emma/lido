<?php

namespace App\Http\Livewire\Phuffycoin;

use App\Models\Mint;
use App\Models\MintTx;
use App\Models\User;
use App\Repositories\EpochRepository;
use App\Services\CardanoWalletService;
use App\Services\PhuffycoinService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MintPhuffycoinComponent extends Component
{
    public array $depositAddress = [];

    public ?int $depositWalletBalance = 0;

    public ?Collection $utxos = null;

    public ?Collection $mints = null;

    public ?Collection $mintTxs = null;

    public int $currEpoch;

    public ?int $mintId = null;

    public int $currentStep = 1;

    protected $queryString = ['mintId'];

    public array $completedSteps = [];

    public ?int $cohortHighestDelegatedAmount;

    public ?Mint $mint = null;

    public string $mintGroup = 'lido';

    public ?int $mintEpoch = null;

    public ?string $mintMemo = null;

    public ?string $mintType = 'pool';

    public ?string $transactionHash = null;

    protected array $rules = [
        'mintType' => 'required|string|min:2',
        'mintMemo' => 'required|string|min:2',
        'mintEpoch' => 'required|number|min:1',
    ];

    public function submitDetails(CardanoWalletService $cardanoWalletService)
    {
        //@todo restore when Cardano service works
        //        $maxEpoch = $this->currEpoch - 1;
        //        $this->rules['mintEpoch'] = "required|numeric|min:1|max:$maxEpoch";
        //        $this->validate();

        if (empty($this->getErrorBag()?->messages())) {
            $this->emit('mintDetailsSubmitted');
        }
        $mint = Mint::where([
            'type' => $this->mintType,
            'epoch' => $this->mintEpoch,
            'group' => $this->mintGroup,
            'memo' => $this->mintMemo,
        ])->first();

        if (! $mint) {
            $mint = new Mint;
            $mint->group = $this->mintGroup;
            $mint->type = $this->mintType;
            $mint->epoch = $this->mintEpoch;
            $mint->user_id = Auth::user()->getAuthIdentifier();
        } elseif ($mint->status === 'minted') {
            $this->addError('already_minted', 'Params match already minted transaction');
        }
        $mint->memo = $this->mintMemo;
        $mint->save();
        $this->mint = $mint;
    }

    public function mount(EpochRepository $epochRepository, CardanoWalletService $cardanoWalletService, PhuffycoinService $phuffycoinService)
    {
        if ((bool) $this->mintId) {
            $this->mint = Mint::findOrFail($this->mintId);
            $this->mintType = $this->mint?->type;
            $this->mintEpoch = $this->mint?->epoch;
            $this->mintGroup = $this->mint?->group;
            $this->mintMemo = $this->mint?->memo;
            $this->depositWalletBalance = $this->mint?->mint_seed_amount / 1000000;

            $this->completedSteps = [1];
            $this->currentStep = 2;
            $this->mintTxs = MintTx::whereHas('mint', fn ($q) => $q->where('id', $this->mintId))
                ->get();
        }
    }

    public function render(): Factory|View|Application
    {
        if ($this->mint?->status === 'minted') {
            $this->completedSteps = [1, 2, 3];
            $this->currentStep = 3;
        } elseif ((bool) $this->mint?->mint_seed_amount && $this->mintTxs?->isNotEmpty()) {
            $this->completedSteps = [1, 2];
            $this->currentStep = 3;
        } elseif ((bool) $this->mint?->mint_seed_amount) {
            $this->completedSteps = [1];
            $this->currentStep = 2;
        }

        return view('livewire.phuffycoin.mint');
    }

    public function generateMintDetails(PhuffycoinService $phuffycoinService)
    {
        $this->mint->mint_seed_amount = ($this->depositWalletBalance ?? 0) * 1000000;
        $this->mint->save();
        $this->mintTxs = MintTx::whereHas('mint', fn ($q) => $q->where('id', $this->mintId))->get();
        if ($this->mintTxs->isNotEmpty()) {
            return null;
        }
        $users = User::whereNotNull('wallet_stake_address')->cursor();
        $txs = collect([]);
        foreach ($users as $user) {
            $score = $phuffycoinService->getUserEpochCohortScore($user, $this->mint->epoch);
            $epochDelegation = $phuffycoinService->getEpochDelegation($user, $this->mint->epoch);

            // null score suggests that user is/was not a delegate in epoch
            if (! $score) {
                continue;
            }
            $tx = new MintTx;
            $tx->score = $score;
            $tx->user_id = $user->id;
            $tx->type = 'mint';
            $tx->status = 'pending';
            $tx->mint_id = $this->mint->id;
            $tx->distribution_percent = 0;
            $tx->amount = 0;
            $tx->policy_id = config('cardano.mint.policies.phuffycoin');
            $tx->save();
            $txs->push($tx);
            $tx->saveMeta('epoch_delegation_amount', $epochDelegation->amount);
        }
        $totalScores = $txs->sum(fn ($tx) => $tx->score);
        $txs->each(function ($tx) use ($totalScores) {
            $tx->distribution_percent = $tx->score / $totalScores;
            $tx->amount = floor($tx->distribution_percent * $this->depositWalletBalance * 1000000);
            $tx->save();
        });
        $this->mintTxs = $txs;
        $this->currentStep = 3;
    }
}
