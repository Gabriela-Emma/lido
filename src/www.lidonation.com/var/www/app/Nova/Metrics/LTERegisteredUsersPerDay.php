<?php

namespace App\Nova\Metrics;

use App\Models\AnswerResponse;
use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;

class LTERegisteredUsersPerDay extends Trend
{
    /**
     * The width of the card (1/3, 2/3, 1/2, 1/4, 3/4, or full).
     *
     * @var string
     */
    public $width = '2/3';

    /**
     * The displayable name of the metric.
     *
     * @var string
     */
    public $name = 'Registered Users Per Day';

    /**
     * Calculate the value of the metric.
     */
    public function calculate(NovaRequest $request): mixed
    {
        return $this->countByDays($request, User::role('learner')->includeDuplicates(false))->showSumValue();
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            15 => __('15 Days'),
            7 => __('7 Days'),
            30 => __('30 Days'),
            45 => __('45 Days'),
            60 => __('60 Days'),
            90 => __('90 Days'),
            180 => __('180 Days'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     */
    public function cacheFor(): ?\DateTimeInterface
    {
        return now()->addMinutes(15);
    }

    /**
     * Get the URI key for the metric.
     */
    public function uriKey(): string
    {
        return 'users-registered-per-day';
    }
}
