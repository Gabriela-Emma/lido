<?php

namespace App\Http\Controllers\Earn;

use App\DataTransferObjects\AnswerResponseData;
use App\DataTransferObjects\LearningLessonData;
use App\DataTransferObjects\RewardData;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLearningLessonRequest;
use App\Http\Requests\UpdateLearningLessonRequest;
use App\Models\AnswerResponse;
use App\Models\Giveaway;
use App\Models\LearningLesson;
use App\Models\Reward;
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
        $learningLesson->load(['model', 'quizzes.questions.answers']);
        if ($learningLesson->model?->content) {
            $learningLesson->model->content = app(MarkdownRenderer::class)
                ->toHtml(
                    Shortcode::compile($learningLesson?->model?->content)
                );
        }

        $userResponses = AnswerResponse::with(['quiz', 'question.answers', 'answer'])->where('user_id', $request->user()?->id)
            ->where('quiz_id', $learningLesson->quiz?->id)
            ->get();

        $reward = $learningLesson->rewards()->where('user_id', $request->user()?->id)->get();
            
        return Inertia::render('LearningLesson', [
            'lesson' => LearningLessonData::from($learningLesson),
            'userResponses' => AnswerResponseData::collection($userResponses),
            'reward' => RewardData::collection($reward),
            'crumbs' => [
                ['label' => 'Learn & Earn', 'link' => route('earn.learn')],
                ['label' => 'Modules', 'link' => route('earn.learn.modules.index')],
                ['label' => $learningLesson->title, 'link' => $learningLesson->link],
            ],
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
