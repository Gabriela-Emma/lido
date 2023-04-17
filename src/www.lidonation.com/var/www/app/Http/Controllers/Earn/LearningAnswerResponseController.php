<?php

namespace App\Http\Controllers\Earn;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AnswerResponse;

class LearningAnswerResponseController extends Controller
{
    public function index(Request $request)
    {
        $responses = AnswerResponse::all();
        return $responses;
    }
    
    public function storeAnswer(Request $request)
    {
        $ans = new AnswerResponse;
        $ans->user_id = $request->input('user_id');
        $ans->question_id = $request->input('question_id');
        $ans->quiz_id = $request->input('quiz_id');
        $ans->question_answer_id = $request->input('question_answer_id');
        
        $ans->save();
    }
}
