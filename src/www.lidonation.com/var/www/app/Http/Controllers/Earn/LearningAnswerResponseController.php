<?php

namespace App\Http\Controllers\Earn;

use App\Jobs\IssueNftsJob;
use App\Models\Nft;
use App\Models\User;
use App\Models\Reward;
use Illuminate\Http\Request;
use App\Models\LearningTopic;
use App\Models\AnswerResponse;
use App\Models\LearningLesson;
use App\Models\QuestionAnswer;
use Illuminate\Support\Carbon;
use App\Models\LearningAttempt;
use App\Repositories\AdaRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Enums\LearningAttemptStatuses;

class LearningAnswerResponseController extends Controller
{
    public function __construct(protected AdaRepository $adaRepository)
    {
    }

    public function index(Request $request)
    {
        return AnswerResponse::with(['quiz', 'question.answers', 'answer'])
            ->where('user_id', $request->user()?->id)
            ->get();
    }

    public function storeAnswer(Request $request)
    {
        $ipAddress = $request->ip();
        $user = Auth::user();

        // get user previous response
        // if user has previous response from today, return
        $nextLessonAt = new Carbon($request->user()->next_lesson_at);
        $canAnswer = now()->tz('Africa/Nairobi')->diff(($nextLessonAt)->tz('Africa/Nairobi')->startOfDay(), false)->invert;

        if (! $canAnswer) {
            return response()->json(['error' => 'Answer submission is only allowed after the next lesson.'], 403);

        }

        $lastResponse = AnswerResponse::where('quiz_id', $request->input('quiz_id'))
            ->where('user_id', $user->id)
            ->whereDate('created_at', '=', Carbon::now()->tz('Africa/Nairobi')->startOfDay())
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastResponse instanceof AnswerResponse) {
            return null;
        }

        $learningLesson = LearningLesson::byHash($request->input('learningLessonHash'));
        $learningTopic = $learningLesson->topic;

        // save answer response
        $ans = new AnswerResponse;
        $ans->user_id = $user->id;
        $ans->question_id = $request->input('question_id');
        $ans->quiz_id = $request->input('quiz_id');
        $ans->question_answer_id = $request->input('question_answer_id');
        $ans->stake_address = $request->input('wallet_stake_address');
        $ans->context_id = $learningLesson->id;
        $ans->context_type = LearningLesson::class;

        $ans->save();

        $ans->saveMeta('ip_address', $ipAddress, $ans, true);
        $this->recordLearningAttempt($ans, $learningLesson);

        // issue nft if topic complete
        $topicCompleted = $user->completedTopics->contains($learningTopic);
        $topicNft = $user->nfts()->where([
            'model_id' => $learningTopic->id,
            'model_type' => LearningTopic::class
        ])->first();

        if($topicCompleted && !$topicNft instanceof Nft){
            IssueNftsJob::dispatch($learningTopic, $learningLesson);
            //return redirect()->route('earn.learn.nft.awarded');
        }

        //issue normal reward
        $this->issueReward($request, $ans->question_answer_id, $learningLesson);
        return back()->withInput();
    }

    protected function issueReward($request, $questionAnswerId, LearningLesson $learningLesson): void
    {
        //find user and update wallet details in case of changes from the browser.
        $user = User::find(Auth::id());
        $user->wallet_address = $request->input('wallet_address') ?? $user->wallet_address;
        $user->wallet_stake_address = $request->input('wallet_stake_address') ?? $user->wallet_stake_address;
        $user->save();

        // is the answer correct
        $answerCorrect = QuestionAnswer::find($questionAnswerId)->correct;

        //extract rewards count from learningLesson

        $rewardsCount = Reward::where('user_id', Auth::id())
            ->where('model_type', LearningLesson::class)
            ->where('model_id', $learningLesson->id)
            ->count();

        // if no reward and answer is correct issue reward.
        if ($rewardsCount < 1 && $answerCorrect == 'true') {
            // get first rule
            $reward = new Reward;
            $reward->user_id = Auth::id();
            $reward->model_id = $learningLesson->id;
            $reward->model_type = LearningLesson::class;

             // get related giveaway
            $giveaway = $learningLesson->topic->giveaway;
            $rule = $giveaway->rules->first();
            if ( ($rule?->subject ?? null) !== 'usd.amount' ) {
                $reward->asset = explode('.',  $rule->subject)[0];
                $reward->asset_type = 'ft';
                $reward->amount = $rule->predicate;
            } else {
                $reward->asset = 'lovelace';
                $reward->asset_type = 'ada';
                $reward->amount = $this->usdInAda();
            }
            $reward->status = 'issued';
            $reward->stake_address = $user->wallet_stake_address;
            $reward->setTranslation('memo', 'en', $learningLesson->title);
            $reward->save();
        }


    }

    protected function usdInAda()
    {
         //fetch quote
         $rewardAmount = -1;
         $quote = $this->adaRepository->quote()?->price ?? null;
         if ($quote) {
             $rewardAmount = 1 / $quote;
         }
         return $rewardAmount > 0 ? number_format($rewardAmount, 6) * 1000000 : 1000000;
    }

    protected function recordLearningAttempt(AnswerResponse $answerResponse, LearningLesson $learningLesson): void
    {
        LearningAttempt::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'learning_lesson_id' => $learningLesson->id,
                'answer_response_id' => $answerResponse->id,
            ],
            [
                'user_id' => Auth::id(),

                'learning_module_id' => $learningLesson->firstModule->id,
                'learning_topic_id' => $learningLesson->topic->id,
                'learning_lesson_id' => $learningLesson->id,

                'quiz_id' => $answerResponse->quiz_id,
                'question_id' => $answerResponse->question_id,
                'question_answer_id' => $answerResponse->question_answer_id,
                'answer_response_id' => $answerResponse->id,

                'status' => $answerResponse->correct ? LearningAttemptStatuses::COMPLETED : LearningAttemptStatuses::STARTED,
            ]
        );
    }
}
