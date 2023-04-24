<?php

namespace App\Http\Controllers\Earn;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLearningTopicRequest;
use App\Http\Requests\UpdateLearningTopicRequest;
use App\Models\LearningTopic;
use Illuminate\Http\Response;

class LearningTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreLearningTopicRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(LearningTopic $learningTopic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(LearningTopic $learningTopic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(UpdateLearningTopicRequest $request, LearningTopic $learningTopic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(LearningTopic $learningTopic)
    {
        //
    }
}
