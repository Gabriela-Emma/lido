<?php

namespace App\Nova;

use App\Models\BookmarkCollection;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Color;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Actions\ExportAsCsv;

class BookmarkCollections extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = BookmarkCollection::class;

    public static $group = 'Catalyst';

    public static $perPageViaRelationship = 15;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Title')
                ->sortable()->withMeta(
                    [
                        'extraAttributes' => [
                            'autocomplete' => 'off',
                        ],
                    ]
                )
                ->required()
                ->rules('max:255'),
            Text::make('View Ballot', function () {
                return '<a style="color: #578ae4" href="'.$this->link.'" target="_blank">View</a>';
            })->asHtml()->hideWhenCreating()->hideWhenUpdating(),
            Color::make('Color'),
            Text::make('visibility')->sortable(),
            Text::make('status')->sortable(),
            DateTime::make('Created At')->sortable(),
            DateTime::make('Updated At')->sortable(),

            BelongsTo::make('User', 'user', User::class)->searchable()->sortable(),

            Markdown::make(__('Content'), 'content')->sortable(),

            HasMany::make('Items', 'items', BookmarkItems::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return array_merge(
            static::getGlobalActions(),
            [
                ExportAsCsv::make()->nameable(),
            ]);
    }
}
