<?php

namespace App\Observers;

use App\Models\Rule;
use App\Models\Reward;
use App\Models\Interfaces\HasRewardsContract;
use App\Jobs\RecalculateRewardsJob;
use Illuminate\Support\Facades\Log;

class RuleObserver
{
    public function updated(Rule $rule)
    {
        // recalculate rewards whenever predicate field is updated
        if ($rule->isDirty('predicate')) {
            if ($rule->model instanceof HasRewardsContract) {
                $rewards = $rule->model?->rewards;

                if ($rewards->isNotEmpty()) {
                    $rewards->each(function (Reward $reward) {
                        RecalculateRewardsJob::dispatch($reward);
                    });
                } else {
                    Log::alert("Rewards not recalculated (rule id " . $rule->id . " might be lacking reward attached).");
                }
            } else {
                Log::alert("Rewards not recalculated (model id-" . $rule->id . "'s 'parent' doesn't implement rewards contract).");
            }

        }
    }
}
