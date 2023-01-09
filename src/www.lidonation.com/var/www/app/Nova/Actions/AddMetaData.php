<?php

namespace App\Nova\Actions;

use App\Models\Interfaces\IHasMetaData;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class AddMetaData extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Add Meta Data';

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (IHasMetaData $m) use ($fields) {
            try {
                $m->saveMeta($fields->name, $fields->value, $m, false);
            } catch (\Exception $e) {
                $this->markAsFailed($m, $e);
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
            Text::make('Name')
                ->required()
                ->rules('max:255'),
            Text::make('Value')
                ->required()
                ->rules('max:255'),
        ];
    }
}
