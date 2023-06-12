<?php

namespace App\Nova\Metrics;

use App\Models\AnswerResponse;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Illuminate\Database\Eloquent\Builder;

class QuizzesTakenCount extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $total = $this->count($request,
            AnswerResponse::whereHas(
                'quiz',
                fn ( Builder $query) => $query->whereHas('lessons')
            )->whereHas(
                'user',
                fn (Builder $userQuery) => $userQuery->includeDuplicates(true)
            )
        );

        $unique = $this->count($request,
            AnswerResponse::whereHas(
                'quiz',
                fn ($query) => $query->whereHas('lessons')
            )->whereHas(
                'user',
                fn ($userQuery) => $userQuery->includeDuplicates(false)
            )
        );
        $duplicates = $total->value - $unique->value;

        return $unique->suffix("({$duplicates} Duplicates)");
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            7 => __('7 Days'),
            15 => __('15 Days'),
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
