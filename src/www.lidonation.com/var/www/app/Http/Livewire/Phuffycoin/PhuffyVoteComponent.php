<?php

namespace App\Http\Livewire\Phuffycoin;

use App\Models\Cause;
use App\Models\Vote;
use App\Models\Wallet;
use App\Repositories\CauseRepository;
use App\Repositories\EpochRepository;
use App\Repositories\VoteRepository;
use App\Services\CardanoGraphQLService;
use App\Services\CardanoWalletService;
use App\Services\PhuffycoinService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use Whoops\Exception\ErrorException;

class PhuffyVoteComponent extends Component
{
    public array $voteDepositAddress = [];

    public ?int $voteDepositWalletBalance = 0;

    public ?int $causeId = null;

    public ?int $voteId = null;

    public int $currentStep = 1;

    public array $completedSteps = [];

    public ?Collection $utxos = null;

    public $causes = [];

    public ?Collection $phuffyUtxos = null;

    public ?int $phuffyUtxosBalance = null;

    public ?Cause $cause = null;

    public ?Vote $vote = null;

    public ?string $transactionHash = null;

    protected ?Wallet $wallet = null;

    protected $queryString = ['causeId', 'voteId'];

    protected array $rules = [
        'causeId' => 'required|numeric|min:1',
    ];

    /**
     * @throws ErrorException
     * @throws GuzzleException
     */
    public function mount(EpochRepository $epochRepository, CardanoWalletService $cardanoWalletService, CardanoGraphQLService $graphQLService, CauseRepository $causes)
    {
        $this->initUi();
        $this->setRules();
        $this->setModels();
        $this->initUi();
        if ($this->currentStep == 2) {
            $this->setDepositWallet();
        }
    }

    public function render(CardanoWalletService $cardanoWalletService, PhuffycoinService $phuffycoinService, CardanoGraphQLService $cardanoGraphQLService): Factory|View|Application
    {
        return view('livewire.phuffycoin.vote');
    }

    public function startVote()
    {
        $this->currentStep = 2;
        $vote = $this->getVoteObject();
        if (! $vote instanceof Vote) {
            return null;
        }

        redirect()->route('phuffy-vote', [
            'causeId' => $this->causeId,
            'voteId' => $vote?->id,
        ]);
    }

    public function validateVote()
    {
        $this->currentStep = 3;
        $this->completedSteps = [1, 2];
    }

    public function checkWalletBalance(CardanoWalletService $cardanoWalletService, CardanoGraphQLService $cardanoGraphQLService)
    {
        if (! $this->vote || ! $this->vote) {
            return;
        }
        $this->utxos = $cardanoGraphQLService->getAddressesTokenUtxos(
            config('cardano.mint.policies.phuffycoin'),
            [$this->voteDepositAddress['id']]
        );

        $this->voteDepositWalletBalance = $this->utxos->sum('quantity') ?? 0;

        if ($this->voteDepositWalletBalance < 5000000) {
            return null;
        }
    }

    /**
     * @throws GuzzleException
     */
    #[NoReturn]
 public function submitVote(PhuffycoinService $phuffycoinService, CardanoWalletService $cardanoWalletService, CardanoGraphQLService $cardanoGraphQLService)
 {
     try {
         $phuffycoinService->submitPhuffyVote($this->vote);
     } catch (\Exception $e) {
         $this->addError('submitTxError', $e->getMessage());
     }

     $this->setModels();
     $this->checkWalletBalance($cardanoWalletService, $cardanoGraphQLService);
     if ($this->getErrorBag()->isEmpty()) {
         $this->vote->status = 'submitted';
         $this->vote->amount = $this->voteDepositWalletBalance;
         $this->vote->save();
         $this->completedSteps = [1, 2, 3];
         $this->initUi();
     }
 }

    protected function getVoteObject(): ?Vote
    {
        if ($this->currentStep == 1) {
            return $this->vote;
        }

        if ((bool) $this->vote) {
            return $this->vote;
        }

        if ((bool) $this->voteId) {
            return Vote::findOrFail($this->voteId);
        }

        if (! $this->causeId) {
            return null;
        }
        // find previous votes
        $vote = Vote::where(
            [
                'cause_id' => $this->causeId,
                'status' => 'pending',
            ]
        )->get()?->first();

        if (! $vote) {
            $vote = new Vote();
            $vote->user_id = auth()?->user()?->getAuthIdentifier();
            $vote->cause_id = $this->causeId;
            $vote->amount = 0;
            $vote->status = 'pending';
            $vote->save();
        }

        return $vote;
    }

    protected function setModels()
    {
        $graphQLService = app(CardanoGraphQLService::class);

        $this->causes = app(CauseRepository::class)->all();
        $this->votes = app(VoteRepository::class)->all();
        $this->cause = Cause::findOrFail($this->causeId);
        $this->vote = $this->getVoteObject();

        $this->phuffyUtxos = $graphQLService->getAddressesTokenUtxos(config('cardano.mint.policies.phuffycoin'));
        $this->phuffyUtxosBalance = $this->phuffyUtxos->sum('quantity');
    }

    protected function setDepositWallet()
    {
        $cardanoWalletService = app(CardanoWalletService::class);
        $graphQLService = app(CardanoGraphQLService::class);

        if ((bool) $this->vote?->id) {
            $wallet = $this->vote->wallets?->first();
            if (! $wallet) {
                // generate and persist new wallet
                $baseDir = "/data/mint/wallets/votes/{$this->vote?->id}";
                $cardanoWalletService->getDepositCliAddress(true, $baseDir);

                $addy = file_get_contents("$baseDir/deposit.addr");
                $skey = file_get_contents("$baseDir/deposit.skey");
                $vkey = file_get_contents("$baseDir/deposit.vkey");

                $wallet = Wallet::where('address', $addy)->first() ?? new Wallet();
                $wallet->address = $addy;
                $wallet->signing_key = $skey;
                $wallet->verification_key = $vkey;
                $wallet->user_id = Auth::user()?->getAuthIdentifier();
                $wallet->context = 'vote';
                $wallet->save();
                $this->vote->wallets()->attach($wallet, ['model_type' => Vote::class]);
                $this->wallet = $wallet;
            }
            $this->voteDepositAddress = $cardanoWalletService
                    ->makeWalletObject($wallet->address)->toArray();
        }

        $this->phuffyUtxos = $graphQLService->getAddressesTokenUtxos(config('cardano.mint.policies.phuffycoin'));
        $this->phuffyUtxosBalance = $this->phuffyUtxos->sum('quantity');
    }

    protected function setRules()
    {
        if ($this->currentStep > 1) {
            $this->rules['voteId'] = 'required|numeric|min:1';
        }

        $this->validate();
    }

    protected function initUi()
    {
        if ((bool) $this->causeId && ! $this->voteId) {
            $this->currentStep = 1;
        } elseif ((bool) $this->causeId && (bool) $this->voteId) {
            $this->currentStep = 2;
            $this->completedSteps = [1];
        }
        if ($this->vote?->submitted) {
            $this->currentStep = 3;
            $this->completedSteps = [1, 2, 3];
        }
    }
}
