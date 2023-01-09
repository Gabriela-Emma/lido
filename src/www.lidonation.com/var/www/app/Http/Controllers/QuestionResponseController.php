<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\StoreQuestionResponseRequest;
use App\Http\Requests\UpdateQuestionResponseRequest;
use App\Models\AnswerResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class QuestionResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreQuestionResponseRequest $request
     * @return AnswerResponse
     */
    public function store(StoreQuestionResponseRequest $request)
    {
        $user = User::where('wallet_stake_address', $request->input('stake_address'))->first();
        if (!$user instanceof User) {
            $user = new User;
            $user->name = $request->stake_address;
            $user->wallet_stake_address = $request->stake_address;
            $user->wallet_address = $request->wallet_address;
            $user->email = $request->email ?? substr($request->stake_address, -4).'@anonymous.com';
            $user->password = Hash::make(Str::random(10));
            $user->save();
        }
        Auth::login($user);

        // check to make sure user haven't already answered this question
        $answer = AnswerResponse::where([
            'user_id' => $user->id,
            'question_id' => $request->input('question'),
            'quiz_id' => $request->input('quiz')
        ])->first();

        // return preview answer if exists
        if ($answer instanceof AnswerResponse) {
            return $answer;
        }

        $answer = new AnswerResponse();
        $answer->quiz_id = $request->input('quiz');
        $answer->question_id = $request->input('question');
        $answer->question_answer_id = $request->input('answer');
        $answer->user_id = $user->id;
        $answer->stake_address = $user->wallet_stake_address;
        $answer->save();
        return $answer;
    }

    /**
     * Display the specified resource.
     *
     * @param AnswerResponse $questionResponse
     * @return \Illuminate\Http\Response
     */
    public function show(AnswerResponse $questionResponse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AnswerResponse $questionResponse
     * @return \Illuminate\Http\Response
     */
    public function edit(AnswerResponse $questionResponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuestionResponseRequest  $request
     * @param AnswerResponse $questionResponse
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionResponseRequest $request, AnswerResponse $questionResponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AnswerResponse $questionResponse
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnswerResponse $questionResponse)
    {
        //
    }
}
