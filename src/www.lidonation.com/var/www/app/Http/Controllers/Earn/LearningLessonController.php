<?php

namespace App\Http\Controllers\Earn;

use App\DataTransferObjects\AnswerResponseData;
use App\DataTransferObjects\LearningLessonData;
use App\DataTransferObjects\RewardData;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLearningLessonRequest;
use App\Http\Requests\UpdateLearningLessonRequest;
use App\Models\AnswerResponse;
use App\Models\LearningLesson;
use App\Models\LearningTopic;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Spatie\LaravelMarkdown\MarkdownRenderer;
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
     * @return void
     */
    public function store(StoreLearningLessonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Inertia\Response
     */
    public function show(Request $request, LearningLesson $learningLesson)
    {
        $user = $request->user();

        $learningLesson->load(['model', 'quizzes.questions.answers', 'topics', 'topics.learningModules']);
        if ($learningLesson->model?->content) {
            $learningLesson->model->content = app(MarkdownRenderer::class)
                ->toHtml(
                    Shortcode::compile($learningLesson?->model?->content)
                );
        }

        $userResponses = AnswerResponse::with(['quiz', 'question.answers', 'answer'])
            ->where(
                [
                    'user_id' => $user?->id,
                    'quiz_id' => $learningLesson->quiz?->id,
                    'context_id' => $learningLesson->id,
                    'context_type' => LearningLesson::class,
                ]
            )
            ->get();

        $reward = $learningLesson->rewards()
            ->where('user_id', $user->id)
            ->first();

        $module = $learningLesson->firstModule;

        $crumbs = [
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
            'nextLessonAt' => $user?->next_lesson_at,
            'lesson' => LearningLessonData::from($learningLesson),
            'userResponses' => AnswerResponseData::collection($userResponses),
            'reward' => isset($reward) ? RewardData::from($reward) : null,
            'crumbs' => $crumbs,
        ]);
    }

    public function getLessons(LearningTopic $learningTopic)
    {
        dd($learningTopic->learningLessons()->get()->toArray());
        return LearningLessonData::collection($learningTopic->learningLessons()->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return void
     */
    public function edit(LearningLesson $learningLesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(UpdateLearningLessonRequest $request, LearningLesson $learningLesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(LearningLesson $learningLesson)
    {
        //
    }
}
