<?php

namespace App\Nova\Metrics;

use App\Models\AnswerResponse;
use App\Models\LearningLesson;
use App\Models\LearningTopic;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class QuizzesTakenCount extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $lessons = LearningLesson::all();
        $learningLessonsQuizzesIds = $lessons->flatMap(function ($lesson) {
            return $lesson->quizzes()->get()->pluck('id');
        });

        return $this->count($request, AnswerResponse::whereIn('quiz_id', $learningLessonsQuizzesIds));
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            30 => __('30 Days'),
            60 => __('60 Days'),
            365 => __('365 Days'),
            'TODAY' => __('Today'),
            'MTD' => __('Month To Date'),
            'QTD' => __('Quarter To Date'),
            'YTD' => __('Year To Date'),
        ];
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
        return 'total-quizzes-attempted';
    }

    public function name() 
    {
        return 'Total Quizzes Attempted';
    }
}