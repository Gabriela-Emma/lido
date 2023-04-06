<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLearningLessonRequest;
use App\Http\Requests\UpdateLearningLessonRequest;
use App\Models\LearningLesson;

class LearningLessonController extends Controller
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
     * @param  \App\Http\Requests\StoreLearningLessonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLearningLessonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LearningLesson  $learningLesson
     * @return \Illuminate\Http\Response
     */
    public function show(LearningLesson $learningLesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LearningLesson  $learningLesson
     * @return \Illuminate\Http\Response
     */
    public function edit(LearningLesson $learningLesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLearningLessonRequest  $request
     * @param  \App\Models\LearningLesson  $learningLesson
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLearningLessonRequest $request, LearningLesson $learningLesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LearningLesson  $learningLesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(LearningLesson $learningLesson)
    {
        //
    }
}
