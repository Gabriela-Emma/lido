<?php

namespace App\Http\Livewire\Delegators;

use App\DataTransferObjects\QuizData;
use App\DataTransferObjects\QuizQuestionData;
use App\Invokables\GetLidoRewardsPot;
use App\Invokables\GetPoolMultiplier;
use App\Models\AnswerResponse;
use App\Models\EveryEpoch;
use App\Models\Giveaway;
use App\Models\Promo;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Reward;
use App\Models\User;
use App\Repositories\PostRepository;
use App\Services\CardanoBlockfrostService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Fluent;
use Livewire\Component;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class DelegatorsComponent extends Component
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

    public $ownNft;

    public $nftLinks = [];

    protected $listeners = [
        'claimEveryEpochReward' => 'claimEveryEpochReward',
    ];

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function mount(PostRepository $posts)
    {
        // get epoch
        $this->epoch = app(CardanoBlockfrostService::class)->get('epochs/latest/', null)->collect();

        $this->everyEpoch = EveryEpoch::with('quizzes.questions.answers')
            ->where('epoch', $this->epoch['epoch'])
            ->orderBy('created_at', 'desc')
            ->first();

        $this->everyEpochQuiz = $this->everyEpoch?->quizzes?->shuffle()?->first();

        $this->partnerPromo = Promo::inRandomOrder()->first();
        $this->rewardsTemplate = $this->everyEpoch
            ?->giveaway->rules()->where('context', 'reward')
            ->get(['predicate', 'subject'])
            ?->map(fn ($t) => [
                $t->subject => intval($t->predicate),
            ])->collapse()->toArray();

        $this->rewardPot = collect(
            (new GetLidoRewardsPot)($this->everyEpoch))
            ->filter(
                fn ($asset) => isset($this->rewardsTemplate[$asset['asset'].'.amount']) && $asset['amount'] >= $this->rewardsTemplate[$asset['asset'].'.amount']
            );

        if (Auth::check() && (bool) auth()->user()?->wallet_stake_address) {
            $user = auth()->user();
            $this->loadUserNfts($user);
            $this->loadLidoRewards($user);

            $this->myResponse = AnswerResponse::with('answer.question')
                ->where([
                    'user_id' => $user->id,
                    'quiz_id' => $this->everyEpochQuiz?->id,
                ])->first();

            if ($this->myResponse instanceof AnswerResponse && $this->myResponse?->answer?->question instanceof Question) {
                $this->everyEpochQuestion = QuizQuestionData::from(Question::with(['answers'])->find($this->myResponse?->question_id))->toArray();
            }
        }

        if (! (is_array($this->everyEpochQuestion) && count($this->everyEpochQuestion)  > 0) && $this->everyEpochQuiz instanceof Quiz) {
            $this->everyEpochQuestion =
                (QuizData::from($this->everyEpochQuiz))?->questions?->first()?->toArray();
        }
    }

    public function claimEveryEpochReward(string $asset)
    {
        // get user
        $user = auth()->user();

        if ($this->everyEpoch->epoch === 53 || 381 || 382) {
            $reward = $this->issueReward($asset);

            $this->saveReward($reward, $user);

            // load and signal browser
            $this->loadLidoRewards($user);

            return;
        }

        // get response from quiz
        $userResponse = AnswerResponse::where([
            'user_id' => $user?->getAuthIdentifier(),
            'quiz_id' => $this->everyEpochQuiz?->id,
        ])->first();

        if (! $userResponse instanceof AnswerResponse) {
            $this->addError('Quiz Not Found',
                'Sorry having trouble finding your response to the quiz.'
            );
        }

        if ($userResponse?->answer?->correctness !== 'correct') {
            $this->addError('Incorrect Answer',
                'Sorry rewards are only awarded for correct response on first try. Try again next epoch.'
            );
        }

        if (! isset($this->rewardsTemplate[$asset.'.amount'])) {
            $this->addError('Error Issuing Reward',
                'We seem to have our wired crossed. Please reach out to support.'
            );
        }

        if (! isset($this->rewardPot[$asset]['amount'])) {
            $this->addError('Asset Not Found',
                'We seem to have our wired crossed. Please reach out to support.'
            );
        }

        $reward = Reward::where(
            'stake_address' , $user?->wallet_stake_address)
            ->where('model_id', $this->everyEpochQuiz?->giveaway->id)
            ->first();
        if (isset($reward->id)) {
            $this->addError('Reward Already Claimed',
                'You may only be rewarded once per quiz per epoch.'
            );
        }

        $available = $this->rewardPot[$asset]['amount'];
        $requestingAmount = $this->rewardsTemplate[$asset.'.amount'];
        if ($available < $requestingAmount) {
            $this->addError('Available Rewards Issue',
                'Sorry, looks like available rewards in selected asset have all been issued. Come back next epoch!'
            );
        }

        if ($this->getErrorBag()?->isNotEmpty()) {
            $this->dispatchErrors();

            return null;
        }

        // temporary for discoin
        if ($this->everyEpoch->epoch === 53 || 381 || 382) {
            $reward = $this->issueReward('5612bee388219c1b76fd527ed0fa5aa1d28652838bcab4ee4ee63197446973636f696e');
            $this->saveReward($reward, $user, false);
        }

        // issue reward of chosen policy matched in giveaway reward rules
        $reward = $this->issueReward($asset);

        $this->saveReward($reward, $user);

        // load and signal browser
        $this->loadLidoRewards($user);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.delegators.app')
            ->layout(
                'livewire.delegators.layout',
                [
                    'metaTitle' => 'Lido Delegators Portal',
                ]
            )->withShortcodes();
    }

    protected function saveReward($reward, $user, $addMultiplier = true)
    {
        if($reward ==null){
            return;
        }
        if (! $addMultiplier) {
            $multiplier = 1.0;
        } else {
            $multiplier = (new GetPoolMultiplier)($user);
        }

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

        $reward = Reward::where(
            'stake_address' , $user?->wallet_stake_address)
            ->where('model_id', $this->everyEpochQuiz?->giveaway->id)
            ->first();
        if (isset($reward->id)) {
            $this->addError('Reward Already Claimed',
                'You may only be rewarded once per quiz per epoch.'
            );
            return null;
        }

        $amount = $this->rewardsTemplate[$asset.'.amount'];
        $reward = new Reward;
        $reward->user_id = $user->id;
        $reward->asset = $asset;
        $reward->model_id = $this->everyEpochQuiz?->giveaway->id;
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

    protected function loadUserNfts(User $user)
    {
        $imagesArr = [];
        try {
            $assets = app(CardanoBlockfrostService::class)->get('accounts/'.$user->wallet_stake_address.'/addresses/assets', null)->collect();

            //loop assets and extract nft images
            foreach ($assets as $asset) {
                $assetMetaObject = app(CardanoBlockfrostService::class)->get('assets/'.$asset['unit'], null)->object();
                $imageMeta = $assetMetaObject->onchain_metadata->image;

                //from image meta establish protocol and the uri
                switch (gettype($imageMeta)) {
                    case "string": //eg "https://cardano.org/favicon-32x32.png"  OR "ipfs://QmbQDvKJeo2NgGcGdnUiUFibTzuKNK5Uij7jzmK8ZccmWp"
                        [$imageProtocol, $imageUri] = explode('://', $imageMeta);
                        break;
                    case "array": //eg ["ipfs://", "QmbQDvKJeo2NgGcGdnUiUFibTzuKNK5Uij7jzmK8ZccmWp"]
                        [$protocol, $uri] = $imageMeta;
                        $imageProtocol = str_replace('://', '', $protocol);
                        $imageUri = $uri;
                        break;
                }

                //generate off-chain link based on the protocol
                switch ($imageProtocol) {
                    case 'ar':
                        $imageLink = 'https://arweave.net/'.$imageUri;
                        array_push($imagesArr, $imageLink);
                        break;
                    case 'ipfs':
                        $imageLink = 'https://cloudflare-ipfs.com/ipfs/'.$imageUri;
                        array_push($imagesArr, $imageLink);
                        break;
                    case 'https':
                        $imageLink = $imageMeta;
                        array_push($imagesArr, $imageLink);
                        break;
                }
            }

            $this->nftLinks = (count($imagesArr) > 0) ? $imagesArr : null;
            $this->ownNft = isset($this->nftLinks) && count($this->nftLinks) > 0;
        } catch (Exception $e) {
            report($e);
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
