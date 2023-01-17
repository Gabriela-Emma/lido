<?php

namespace App\Nova\Actions;

use App\Jobs\RecalculateRewardsJob;
use App\Models\Interfaces\HasRules;
use App\Models\Reward;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class RecalculateRewards extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Recalculate Rewards';

    /**
     * Indicates if this action is only available on the resource detail view.
     *
     * @var bool
     */
    public $onlyOnDetail = false;

    /**
     * The text to be used for the action's confirm button.
     *
     * @var string
     */
    public $confirmButtonText = 'Recalculate';

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     * @return void
     */
    public function handle(ActionFields $fields, Collection $models): void
    {
        $models->each(function (HasRules|Reward $model) {
            try {
                if ($model instanceof HasRules) {
                    foreach ($model->rewards()->cursor() as $m) {
                        RecalculateRewardsJob::dispatch($m);
                    }
                } else {
                    RecalculateRewardsJob::dispatch($model);
                }
            } catch (Exception $e) {
                $this->markAsFailed($model, $e);
            }
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [];
    }
}
