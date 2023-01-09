<?php

namespace App\Nova\Actions;

use App\Jobs\SyncTranslationJob;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class TranslateModel extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Generate Translations';

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
    public $confirmButtonText = 'Generate';

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     * @return string[]|void
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        if (isset($fields->translation) && ! isset($fields->language)) {
            return Action::danger('You forgot to pick a language.');
        }

        if (! isset($fields->targets)) {
            return Action::danger('You forgot to set a target.');
        }

        $models->each(fn ($model) => (collect($fields->targets))
                ->each(fn ($target) => collect($model->translatable)->each(function ($field) use ($model, $fields, $target) {
                    if (! in_array($field, $model->translatableExcludedFromGeneration)) {
                        SyncTranslationJob::dispatch($model, $field, $fields->source, $target, $fields->publish, $fields->pre_populate);
                    }
                })
                )
        );
    }

    /**
     * Get the fields available on the action.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Heading::make('Add a new Translation'),
            Select::make(__('Source'), 'source')
                ->options(
                    collect(
                        config('laravellocalization.supportedLocales'))
                        ->mapWithKeys(fn ($lang) => ([
                            $lang['key'] => $lang['native'],
                        ])
                        )
                ),
            MultiSelect::make(__('Targets'), 'targets')
                ->options(
                    collect(
                        config('laravellocalization.supportedLocales'))
                        ->mapWithKeys(fn ($lang) => ([
                            $lang['key'] => $lang['native'],
                        ])
                        )
                ),
            Boolean::make(__('Pre Populate'), 'pre_populate')
                ->help(__('If checked, the translation will be pre-populated with the current value.')),
            Boolean::make(__('Publish'), 'publish')
                ->help(__('If checked, the translation will be published.')),
        ];
    }
}
