<?php

namespace App\Nova\Metrics;

use App\Models\AnswerResponse;
use App\Models\LearningLesson;
use App\Models\Reward;
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
        $totalAttempts = AnswerResponse::all()
                                ->count();
        $correctAnswers = Reward::where('model_type', LearningLesson::class)
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
        return 'Responses Correctness (lte)';
    }
}
