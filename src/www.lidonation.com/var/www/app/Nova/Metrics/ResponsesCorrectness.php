<?php

namespace App\Nova\Metrics;

use App\Models\AnswerResponse;
use App\Models\LearningLesson;
use App\Models\QuestionAnswer;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Illuminate\Database\Eloquent\Builder;

class ResponsesCorrectness extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        // $lessons = LearningLesson::all();
        // $learningLessonsQuizzesIds = $lessons->flatMap(function ($lesson) {
        //     return $lesson->quizzes()->get()->pluck('id');
        // });
        // $correctAnswersIds = QuestionAnswer::query()->where('correctness', 'correct')->pluck('id');

        // $totalAttempts = AnswerResponse::whereIn('quiz_id', $learningLessonsQuizzesIds)->count();
        // $correctAnswers = AnswerResponse::whereIn('quiz_id', $learningLessonsQuizzesIds)
        //     ->whereIn('question_answer_id', $correctAnswersIds)
        //     ->count();

        // return $this->result([
        //     'Correct answers' => $correctAnswers,
        //     'Incorrect answers' => $totalAttempts - $correctAnswers,
        // ])->colors(['green', 'red']);




        $totalAttempts = AnswerResponse::whereHas('quiz', fn (Builder $query) => $query->whereHas('lessons'))
            ->whereHas('user', fn (Builder $userQuery) => $userQuery->includeDuplicates(true))
            ->count();

        $correctAnswers = AnswerResponse::whereHas('quiz', fn (Builder $query) => $query->whereHas('lessons'))
            ->whereHas('user', fn (Builder $userQuery) => $userQuery->includeDuplicates(true))
            ->whereRelation('answer', 'correctness', '=', 'correct')
            // ->whereIn('question_answer_id', $correctAnswersIds)
            ->count();

        return $this->result([
            'Correct answers' => $correctAnswers,
            'Incorrect answers' => $totalAttempts - $correctAnswers,
        ])->colors(['green', 'red']);
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'responses-correctness';
    }

    public function name()
    {
        return 'Responses Correctness';
    }
}
