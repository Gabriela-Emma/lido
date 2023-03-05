<?php

namespace App\Nova;

use App\Models\Definition;
use App\Nova\Actions\TranslateModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Definitions extends Resource
{
    /**
     * The model the resource corresponds to.
     */
    public static string $model = Definition::class;

    /**
     * Custom priority level of the resource.
     */
    public static int $priority = 999991;

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
        'name',
        'content',
    ];

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        $query->withoutGlobalScopes();

        return parent::indexQuery($request, $query);
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Name'), 'name')->onlyOnForms(),
            Stack::make('Details', [
                Text::make(__('Name'), 'name'),
                Slug::make(__('Slug'), 'slug'),
            ]),
            Select::make(__('Status'), 'status')->options([
                'published' => 'Published',
                'draft' => 'Draft',
                'pending' => 'Pending',
                'scheduled' => 'Scheduled',
            ]),
            Number::make(__('Weight'), 'weight')->sortable()->hideWhenUpdating()->hideWhenCreating(),
            Markdown::make(__('Content'), 'content'),
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
    public function actions(Request $request): array
    {
        return array_merge(
            static::getGlobalActions(),
            [
                (new TranslateModel),
            ]);
    }
}
