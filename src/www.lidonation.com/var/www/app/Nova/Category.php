<?php

namespace App\Nova;

use App\Nova\CatalystExplorer\Proposals;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Color;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphedByMany;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;

class Category extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Category::class;

    public static $group = 'Meta Data';

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
        'id',
        'slug',
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
            Text::make(__('Title'))->hideFromIndex(),
            Text::make(__('Meta Title'))->hideFromIndex(),
            Slug::make(__('Slug'))->hideFromIndex(),
            Stack::make('Details', [
                Text::make(__('Title'), 'title'),
                Slug::make(__('Slug'), 'slug'),
            ]),
            BelongsTo::make(__('Parent'), 'parent', self::class)
                ->nullable(),
            Images::make(__('Hero'), 'hero')->enableExistingMedia(),
            Markdown::make(__('Content'), 'content')->sortable(),

            //            MorphToMany::make('models')

            MorphedByMany::make('Proposals', 'proposals', Proposals::class)
                ->searchable(),

            MorphedByMany::make('Posts', 'posts', Articles::class),

            MorphedByMany::make('Review', 'reviews', Reviews::class)
                ->searchable(),

            //            MorphedByMany::make('Articles', 'posts', Articles::class),

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
        return array_merge(
            static::getGlobalActions(),
            [
                ExportAsCsv::make()->nameable(),
            ]);
    }
}
