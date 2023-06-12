<?php

namespace App\Http\Controllers\Earn;

use App\Enums\LearningAttemptStatuses;
use App\Http\Controllers\Controller;
use App\Models\AnswerResponse;
use App\Models\LearningAttempt;
use App\Models\LearningLesson;
use App\Models\QuestionAnswer;
use App\Models\Reward;
use App\Models\User;
use App\Repositories\AdaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
        // get user previous response
        // if user has previous response from today, return
        $nextLessonAt = new Carbon($request->user()->next_lesson_at);
        $canAnswer = now()->tz('Africa/Nairobi')->diff(($nextLessonAt)->tz('Africa/Nairobi')->startOfDay(), false)->invert;

        if (! $canAnswer) {
            return response()->json(['error' => 'Answer submission is only allowed after the next lesson.'], 403);

        }

        $lastResponse = AnswerResponse::where('quiz_id', $request->input('quiz_id'))
            ->where('user_id', auth()->user()->getAuthIdentifier())
            ->whereDate('created_at', '=', Carbon::now()->tz('Africa/Nairobi')->startOfDay())
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastResponse instanceof AnswerResponse) {
            return null;
        }

        // save answer response
        $ans = new AnswerResponse;
        $ans->user_id = Auth::id();
        $ans->question_id = $request->input('question_id');
        $ans->quiz_id = $request->input('quiz_id');
        $ans->question_answer_id = $request->input('question_answer_id');
        $ans->stake_address = $request->input('wallet_stake_address');
        $ans->save();

        $learningLesson = LearningLesson::byHash($request->input('learningLessonHash'));
        $this->recordLearningAttempt($ans, $learningLesson);
        $this->issueReward($request, $ans->question_answer_id, $learningLesson);

        return back()->withInput();
    }

    protected function issueReward($request, $questionAnswerId, LearningLesson $learningLesson): void
    {
        //fetch quote
        $rewardAmount = -1;
        $quote = $this->adaRepository->quote()?->price ?? null;
        if ($quote) {
            $rewardAmount = 1 / $quote;
        }

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
            $reward = new Reward;
            $reward->user_id = Auth::id();
            $reward->asset = 'lovelace';
            $reward->model_id = $learningLesson->id;
            $reward->model_type = LearningLesson::class;
            $reward->asset_type = 'ada';
            $reward->amount = $rewardAmount > 0 ? number_format($rewardAmount, 6) * 1000000 : 1000000;
            $reward->status = 'issued';
            $reward->stake_address = $user->wallet_stake_address;
            $reward->setTranslation('memo', 'en', $learningLesson->title);
            $reward->save();
        }
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
