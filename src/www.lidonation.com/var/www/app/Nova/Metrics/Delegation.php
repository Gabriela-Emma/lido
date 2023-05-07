<?php

namespace App\Nova\Metrics;

use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class Delegation extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $lidoPoolId = config('cardano.pool.hash');

        $lidoCount = User::where('active_pool_id', '=', $lidoPoolId)->count();
        $otherPoolsCount = User::where('active_pool_id', '!=', $lidoPoolId)
            ->whereNotNull('active_pool_id')
            ->count();
        $undelegatedCount = User::whereNull('active_pool_id')
            ->whereNotNull('wallet_stake_address')
            ->count();
        $unknownCount = User::whereNull('active_pool_id')
            ->whereNull('wallet_stake_address')
            ->count();

        return $this->result([
            'Lido' => $lidoCount,
            'Other pools' => $otherPoolsCount,
            'Undelegated' => $undelegatedCount,
            'Unknown' => $unknownCount,
        ]);
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
        return 'delegation';
    }
}
