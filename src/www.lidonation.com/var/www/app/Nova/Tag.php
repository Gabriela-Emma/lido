<?php

namespace App\Nova;

use App\Nova\CatalystExplorer\Funds;
use App\Nova\CatalystExplorer\Proposals;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\Color;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphedByMany;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;

class Tag extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Tag::class;

    public static $perPageViaRelationship = 15;

    public static $group = 'Meta Data';

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
        'id',
        'title',
        'content',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Title'))->sortable(),
            Text::make(__('Meta Title')),
            Slug::make(__('Slug'))->sortable(),
            Markdown::make(__('Content'), 'content')->sortable(),

            MorphedByMany::make('Funds', 'funds', Funds::class),

            MorphedByMany::make('Proposals', 'proposals', Proposals::class),

            MorphedByMany::make('Post', 'posts', Articles::class),

            MorphedByMany::make('Review', 'reviews', Reviews::class),

            MorphedByMany::make('Articles', 'posts', Articles::class),

            Color::make(__('Color'))->nullable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request)
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
        return [
            ExportAsCsv::make()->nameable(),
        ];
    }
}
