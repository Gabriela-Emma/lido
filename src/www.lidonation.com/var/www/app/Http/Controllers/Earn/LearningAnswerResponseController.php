<?php

namespace App\Http\Controllers\Earn;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AnswerResponse;
use App\Models\Giveaway;
use App\Models\LearningLesson;
use App\Models\QuestionAnswer;
use App\Models\Quiz;
use App\Models\Reward;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LearningAnswerResponseController extends Controller
{
    public function index(Request $request)
    {
        return AnswerResponse::with(['quiz', 'question.answers', 'answer'])
            ->where('user_id', $request->user()?->id)
            ->get();
    }

    public function storeAnswer(Request $request)
    {   
        // save answer response
        $ans = new AnswerResponse;
        $ans->user_id = Auth::id();
        $ans->question_id = $request->input('question_id');
        $ans->quiz_id = $request->input('quiz_id');
        $ans->question_answer_id = $request->input('question_answer_id');

        $ans->save();

        //extract user
        $user = User::find(Auth::id());
        $answerCorrect = QuestionAnswer::find($ans->question_answer_id)->correct;
        
        //extract rewards count from learningLesson
        $learningLesson = LearningLesson::byHash($request->input('learningLessonHash'));
        $rewardsCount =  Reward::where('user_id', Auth::id())
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
            $reward->amount = 1000000;
            $reward->status = 'issued';
            $reward->stake_address = $user->wallet_stake_address ?? $request->input('wallet_stake_addr');
            $reward->wallet_address = $user->wallet_address ?? $request->input('wallet_addr');
            $reward->setTranslation('memo', 'en', $learningLesson->title);
            $reward->save();
        }

        return back()->withInput();
    }
}
