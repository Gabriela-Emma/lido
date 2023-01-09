<?php

namespace App\Nova\Actions;

use App\Models\Model;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class EditModel extends Action implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Edit Model';

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (Model $m) use ($fields) {
            try {
                $m->{$fields->name} = $fields->value;
                $m->save();
                $this->markAsFinished($m);
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
