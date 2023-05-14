<?php

namespace App\Nova\Metrics;

use App\Models\AnswerResponse;
use App\Models\LearningLesson;
use App\Models\Reward;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class ResponsesCorrectness extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $lessonsQuizIds = DB::table('model_quiz')->where('model_type', LearningLesson::class)->pluck('id');
        $questionsId = DB::table('question_answers')->distinct()->pluck('question_id');
        $correctAnswersIds = DB::table('question_answers')->where('correctness', 'correct')->pluck('id');

        $totalAttempts = AnswerResponse::whereIn('quiz_id', $lessonsQuizIds)->whereIn('question_id', $questionsId)->count();
        $correctAnswers = AnswerResponse::whereIn('quiz_id', $lessonsQuizIds)
                                ->whereIn('question_id', $questionsId)
                                ->whereIn('question_answer_id', $correctAnswersIds)
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
