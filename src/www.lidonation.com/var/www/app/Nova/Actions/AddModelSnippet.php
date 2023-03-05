<?php

namespace App\Nova\Actions;

use App\Models\Snippet;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class AddModelSnippet extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Add Snippet';

    /**
     * Indicates if this action is only available on the resource detail view.
     *
     * @var bool
     */
    public $onlyOnDetail = true;

    /**
     * The text to be used for the action's confirm button.
     *
     * @var string
     */
    public $confirmButtonText = 'Create';

    /**
     * Perform the action on the given models.
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $model = $models->first();

        if ($models->count() > 1) {
            return Action::danger('Please run this on only one article resource.');
        }

        if (
            ! isset($fields->name) ||
            ! isset($fields->content)
        ) {
            return Action::danger('Missing Required fields.');
        }

        $snippet = new Snippet;
        $snippet->name = $fields->name;
        $snippet->context = $fields->context;
        $snippet->status = $fields->status;
        $snippet->order = $fields->order;
        $snippet->content = $fields->content;
        $snippet->save();
        $model->snippets()->attach($snippet, ['model_type' => $model::class]);
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            //            Heading::make('Add Snippet'),
            Text::make('Name'),
            Text::make('Context')->default(fn () => 'global'),
            Select::make(__('Status'), 'status')->options([
                'published' => 'Published',
                'draft' => 'Draft',
                'pending' => 'Pending',
                'ready' => 'Ready',
                'scheduled' => 'Scheduled',
            ])->default(fn () => 'draft'),
            Number::make(__('Order'))->default(fn () => 0),
            //            Text::make(__('Type'))->default(fn(NovaRequest $request) => ($request->model()::class) ),
            Markdown::make(__('Content')),
        ];
    }
}
