<?php

namespace App\Http\Controllers\Earn;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AnswerResponse;
use App\Models\LearningLesson;
use App\Http\Controllers\Controller;
use App\DataTransferObjects\RewardData;
use Webwizo\Shortcodes\Facades\Shortcode;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use App\DataTransferObjects\AnswerResponseData;
use App\DataTransferObjects\LearningLessonData;
use App\Http\Requests\StoreLearningLessonRequest;
use App\Http\Requests\UpdateLearningLessonRequest;

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
     * @return void
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

        $learningLesson->load(['model', 'quizzes.questions.answers','topics', 'topics.learningModules']);
        if ($learningLesson->model?->content) {
            $learningLesson->model->content = app(MarkdownRenderer::class)
                ->toHtml(
                    Shortcode::compile($learningLesson?->model?->content)
                );
        }

        $userResponses = AnswerResponse::with(['quiz', 'question.answers', 'answer'])
            ->where('user_id', $request->user()?->id)
            ->where('quiz_id', $learningLesson->quiz?->id)
            ->get();

        $reward = $learningLesson->rewards()
            ->where('user_id', $request->user()?->id)
            ->first();

        $module = $learningLesson->firstModule;

        $crumbs =  [
            ['name' => 'Learn & Earn', 'link' => route('earn.learn')],
            ['name' => 'Modules', 'link' => route('earn.learn.modules.index')],
            ['name' => $learningLesson->title, 'link' => $learningLesson->link],
        ];

        if ($module !== null) {
            array_splice($crumbs, 2, 0, [
                ['name' => $module->title, 'link' => route('earn.learn.modules.view', $module->slug)],
            ]);
        }

        return Inertia::render('LearningLesson', [
            'nextLessonAt' => $request->user()?->next_lesson_at ,
            'lesson' => LearningLessonData::from($learningLesson),
            'userResponses' => AnswerResponseData::collection($userResponses),
            'reward' => isset($reward) ? RewardData::from($reward) : null,
            'crumbs' =>$crumbs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LearningLesson $learningLesson
     * @return void
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
