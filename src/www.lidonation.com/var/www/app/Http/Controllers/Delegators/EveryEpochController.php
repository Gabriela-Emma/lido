<?php

namespace App\Http\Controllers\Delegators;

use App\DataTransferObjects\QuizData;
use App\Http\Controllers\Controller;
use App\Http\Integrations\Blockfrost\Requests\BlockfrostRequest;
use App\Invokables\GetLidoRewardsPot;
use App\Invokables\GetPoolMultiplier;
use App\Models\AnswerResponse;
use App\Models\EveryEpoch;
use App\Models\Quiz;
use App\Models\Reward;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EveryEpochController extends Controller
{
    public $epoch;

    public $everyEpoch;

    public $everyEpochQuiz;

    public $rewardsTemplate;

    public $everyEpochQuestion;

    public $myResponse;

    public $rewardPot;

    public $errors = [];

    public function __construct()
    {
        $this->getEveryEpoch();
        $this->getEpochDetails();
    }

    public function getEveryEpoch()
    {
        $frostReq = new BlockfrostRequest('/epochs/latest/');
        $this->epoch = $frostReq->send()->json();

        $this->everyEpoch = EveryEpoch::with('quizzes.questions.answers')
            ->where('epoch', $this->epoch['epoch'])
            ->orderBy('created_at', 'desc')
            ->first();

        return $this->everyEpoch;
    }

    public function getEpochDetails()
    {

        $this->everyEpochQuiz = optional($this->everyEpoch)->quizzes
            ->shuffle()
            ->first();
        $this->rewardsTemplate = optional($this->everyEpoch)
            ->giveaway
            ->rules()
            ->where('context', 'reward')
            ->get(['predicate', 'subject'])
            ->mapWithKeys(function ($t) {
                return [
                    $t->subject => intval($t->predicate),
                ];
            })
            ->toArray();

        $this->rewardPot = collect((new GetLidoRewardsPot)($this->everyEpoch))
            ->filter(
                fn ($asset) => isset($this->rewardsTemplate[$asset['asset'].'.amount']) && $asset['amount'] >= $this->rewardsTemplate[$asset['asset'].'.amount']
            );

        $user = Auth::user();
        if ($user && $user->wallet_stake_address) {
            $this->myResponse = AnswerResponse::with('answer.question')
                ->where([
                    'user_id' => $user->id,
                    'quiz_id' => optional($this->everyEpochQuiz)->id,
                ])->first();
        }

    }

    public function getEpochQuestion()
    {

        return QuizData::from($this->everyEpochQuiz);
    }

    public function getEpochRewardsPot()
    {

        return $this->rewardPot;
    }

    public function epochQuestionAnswer(Request $request)
    {

        if (! $request->user()) {
            return null;
        }

        return $this->myResponse;
    }

    public function getRewardTemplate()
    {

        return $this->rewardsTemplate;
    }

    protected function issueReward(string $asset): ?Reward
    {
        $user = auth()->user();

        $reward = Reward::where(
            'stake_address',
            $user?->wallet_stake_address
        )
            ->where('model_id', $this->everyEpoch?->giveaway?->id)
            ->first();

        if (isset($reward->id)) {
            $this->errors['Reward claimed'] = 'Reward Already Claimed, You may only be rewarded once per quiz per epoch.';
        }

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

    protected function saveReward($reward, $user, $addMultiplier = true)
    {
        if ($reward == null) {
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
            'memo',
            'en',
            "{$this->everyEpoch->title} reward".($multiplier > 1 ? ' with Multiplier' : '')
        );
        $reward->save();
    }

    public function claimEveryEpochReward(Request $request)
    {
        $asset = $request->input('asset');
        // get user
        $user = auth()->user();

        if ($this->everyEpoch->epoch === 53 || 381 || 382) {
            $reward = $this->issueReward($asset);

            $this->saveReward($reward, $user);

            return $reward;
        }

        // get response from quiz
        $userResponse = AnswerResponse::where([
            'user_id' => $user?->getAuthIdentifier(),
            'quiz_id' => $this->everyEpochQuiz?->id,
        ])->first();

        if (! $userResponse instanceof AnswerResponse) {
            return response()->json(['Quiz Not Found' => 'Sorry, having trouble finding your response to the quiz.'], 409);
        }

        if ($userResponse?->answer?->correctness !== 'correct') {
            return response()->json(['Incorrect Answer' => 'Sorry, rewards are only awarded for a correct response on the first try. Try again next epoch.'], 409);
        }

        if (! isset($this->rewardsTemplate[$asset.'.amount'])) {
            return response()->json(['Error Issuing Reward' => 'We seem to have our wires crossed. Please reach out to support.'], 409);
        }

        if (! isset($this->rewardPot[$asset]['amount'])) {
            return response()->json(['Asset Not Found' => 'We seem to have our wires crossed. Please reach out to support.'], 409);
        }

        $reward = Reward::where('stake_address', $user?->wallet_stake_address)
            ->where('model_id', $this->everyEpochQuiz?->giveaway->id)
            ->first();

        if (isset($reward->id)) {
            return response()->json(['Reward Already Claimed' => 'You may only be rewarded once per quiz per epoch.'], 409);
        }

        $available = $this->rewardPot[$asset]['amount'];
        $requestingAmount = $this->rewardsTemplate[$asset.'.amount'];

        if ($available < $requestingAmount) {
            return response()->json(['Available Rewards Issue' => 'Sorry, it looks like all available rewards in the selected asset have been issued. Come back next epoch!', 409]);
        }

        // issue reward of chosen policy matched in giveaway reward rules
        $reward = $this->issueReward($asset);

        $this->saveReward($reward, $user);

        return $reward;
    }
}
