<?php

namespace App\Nova\Actions;

use App\Models\Category;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class AttachCategory extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Attach Category';

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
    public $confirmButtonText = 'Attach';

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function ($model) use ($fields) {
            try {
                $model->categories()->attach($fields->cat, ['model_type' => $model::class]);
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
        return [
            Select::make('Category', 'cat')->options(Category::pluck('title', 'id'))->searchable(),
        ];
    }
}
