<?php

namespace App\Http\Controllers\Earn;

use App\DataTransferObjects\LearningLessonData;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLearningLessonRequest;
use App\Http\Requests\UpdateLearningLessonRequest;
use App\Models\LearningLesson;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Webwizo\Shortcodes\Facades\Shortcode;

class LearningLessonController extends Controller
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
     * @param StoreLearningLessonRequest $request
     * @return Response
     */
    public function store(StoreLearningLessonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param LearningLesson $learningLesson
     * @return \Inertia\Response
     */
    public function show(Request $request, LearningLesson $learningLesson)
    {
        $learningLesson->load('model');
        if ($learningLesson->model?->content) {
            $learningLesson->model->content = Shortcode::compile($learningLesson?->model?->content);
        }
        return Inertia::render('LearningLesson', [
            'lesson' => LearningLessonData::from($learningLesson)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LearningLesson $learningLesson
     * @return Response
     */
    public function edit(LearningLesson $learningLesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLearningLessonRequest $request
     * @param LearningLesson $learningLesson
     * @return Response
     */
    public function update(UpdateLearningLessonRequest $request, LearningLesson $learningLesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param LearningLesson $learningLesson
     * @return Response
     */
    public function destroy(LearningLesson $learningLesson)
    {
        //
    }
}
