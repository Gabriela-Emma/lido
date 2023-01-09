<?php

namespace App\Nova\Metrics;

use App\Models\Reward;
use Illuminate\Support\Carbon;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class RewardStatus extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param NovaRequest $request
     * @return PartitionResult
     */
    public function calculate(NovaRequest $request): PartitionResult
    {
        return $this->count($request, Reward::class, 'status');
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return Carbon
     */
    public function cacheFor()
    {
        if (app()->environment('production')) {
            return now()->addMinutes(5);
        }
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'rewards-status';
    }
}
