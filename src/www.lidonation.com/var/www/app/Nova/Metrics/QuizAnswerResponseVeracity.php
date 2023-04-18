<?php

namespace App\Nova\Metrics;

use App\Models\AnswerResponse;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class QuizAnswerResponseVeracity extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param NovaRequest $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->result([
            'Correct' => AnswerResponse::whereRelation('answer', 'correctness', 'correct')->count(),
            'Incorrect' => AnswerResponse::whereRelation('answer', 'correctness', 'incorrect')->count(),
        ])->label(function ($value) {
            return $value;
        })->colors([
            'Correct' => 'green',
            'Incorrect' => 'red',
        ]);
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        return now()->addMinutes(10);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'quiz-answer-response-veracity';
    }
}
