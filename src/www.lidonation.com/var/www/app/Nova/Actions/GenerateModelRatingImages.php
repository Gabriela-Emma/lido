<?php

namespace App\Nova\Actions;

use App\Jobs\GenerateReviewRatingImagesJob;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class GenerateModelRatingImages extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Generate Rating Summary Images';

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
    public $confirmButtonText = 'Generate Images';

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     * @return array
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function ($model) {
            try {
                GenerateReviewRatingImagesJob::dispatch($model);
            } catch (Exception $e) {
                $this->markAsFailed($model, $e);
            }
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [];
    }
}
