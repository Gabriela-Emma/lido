<?php

namespace App\Jobs;

use App\Invokables\GetPoolMultiplier;
use App\Models\Interfaces\HasRules;
use App\Models\Reward;
use App\Models\Rule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class RecalculateRewardsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected Reward $reward)
    {
    }

    /**
     * Execute the job.
     *
     *
     * @throws \Exception
     */
    public function handle(): void
    {
        // get related giveaway
        $ruleModel = $this->reward->model;

        // get matching rule
        if (! $ruleModel instanceof HasRules) {
            $ruleModelClass = $ruleModel::class;
            throw new \Exception("{$ruleModelClass} must implement ".HasRules::class);
        }

        $asset = $this->reward?->asset;
        $rule = $ruleModel?->rules?->firstWhere('subject', "{$asset}.amount");
        if (! $rule instanceof Rule) {
            throw (new ModelNotFoundException())->setModel(Rule::class);
        }

        $multiplier = (new GetPoolMultiplier)($this->reward?->user);
        $amount = intval($rule->predicate);

        // update reward amount based on rule and multiplier
        $this->reward->amount = $amount * $multiplier;

        $this->reward->save();
    }

    /**
     * Get the middleware the job should pass through.
     */
    public function middleware(): array
    {
        return [(new WithoutOverlapping($this->reward->id))->releaseAfter(12)];
    }
}
