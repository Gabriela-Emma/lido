<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLearningTopicRequest;
use App\Http\Requests\UpdateLearningTopicRequest;
use App\LearningTopic;

class LearningTopicController extends Controller
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
     * @param  \App\Http\Requests\StoreLearningTopicRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLearningTopicRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LearningTopic  $learningTopic
     * @return \Illuminate\Http\Response
     */
    public function show(LearningTopic $learningTopic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LearningTopic  $learningTopic
     * @return \Illuminate\Http\Response
     */
    public function edit(LearningTopic $learningTopic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLearningTopicRequest  $request
     * @param  \App\LearningTopic  $learningTopic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLearningTopicRequest $request, LearningTopic $learningTopic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LearningTopic  $learningTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(LearningTopic $learningTopic)
    {
        //
    }
}
