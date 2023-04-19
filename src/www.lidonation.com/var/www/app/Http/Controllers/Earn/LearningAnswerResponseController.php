<?php

namespace App\Http\Controllers\Earn;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AnswerResponse;
use Illuminate\Support\Carbon;

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
        // get user previous response
        // if user has previous response from today, return
        $lastResponse = AnswerResponse::where('quiz_id',  $request->input('quiz_id'))
            ->where('user_id', auth()->user()->getAuthIdentifier())
            ->whereDate('created_at', "=", Carbon::now()->tz('Africa/Nairobi')->startOfDay())
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastResponse instanceof AnswerResponse) {
            return null;
        }

        $ans = new AnswerResponse;
        $ans->user_id = $request->input('user_id');
        $ans->question_id = $request->input('question_id');
        $ans->quiz_id = $request->input('quiz_id');
        $ans->question_answer_id = $request->input('question_answer_id');

        $ans->save();

        return back()->withInput();
    }
}
