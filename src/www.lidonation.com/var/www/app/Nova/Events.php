<?php

namespace App\Nova;

use App\Models\Event;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Actions\ExportAsCsv;

class Events extends Resource
{
    public static $group = 'Events';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Event::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'content',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make(__('Name'))
                ->sortable()
                ->required()
                ->rules('max:255')
                ->translatable(),

            DateTime::make(__('Starts'), 'starts_at')->sortable(),
            DateTime::make(__('Ends'), 'ends_at')->sortable(),
            DateTime::make(__('Posting Expires'), 'expires_at')->sortable(),
            DateTime::make(__('Created'), 'created_at')->sortable(),
            Markdown::make(__('Content'))->translatable(),

            HasMany::make('Metadata', 'metas', Metas::class),
        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    #[Pure]
    public function actions(Request $request): array
    {
        return array_merge(
            static::getGlobalActions(),
            [
                (new AddMetaData),
                (new EditMetaData(Event::class)),
                ExportAsCsv::make()->nameable(),
            ]);
    }
}
