<?php

namespace App\Listeners\Metrics;

use App\Events\CalculateCardanoMetricsEvent;
use App\Services\CardanoGraphQLService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SavePaidToDelegatesMetric implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(CalculateCardanoMetricsEvent $event, CardanoGraphQLService $cardanoGraphQLService)
    {
        // @todo implement actual code
        // get the data from cardano
        $paidToDelegates = $cardanoGraphQLService->getPoolDelegationRewardsSum();

        // create a new metric model
        // $metric = new Metric();

        // add the metric
        // $metric->key = 'paid_to_delegates';
        // $metric->value = $paidToDelegates;
        // $metric->name = 'Paid to Delegates';

        // save the model.
        // $metric->save();
    }
}
