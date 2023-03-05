<?php

namespace App\Nova;

use App\Models\PodcastSeason;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class PodcastSeasons extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = PodcastSeason::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Podcast';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
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
            Text::make(__('Name')),
            BelongsTo::make('Show', 'show', PodcastShows::class)->searchable(),
            BelongsTo::make('Host', 'host', User::class)->searchable(),
            BelongsTo::make('Author', 'author', User::class)->searchable()->hideFromIndex(),
            Select::make(__('Status'), 'status')->options([
                'draft' => 'Draft',
                'live' => 'Live',
                'completed' => 'Completed',
                'published' => 'Published',
                'canceled' => 'Cancelled',
            ])->sortable(),
            Images::make(__('Hero'), 'hero')
                ->enableExistingMedia(),
            Markdown::make('Content', 'content')->translatable()->alwaysShow(),
            HasMany::make('episodes', 'episodes', Podcasts::class),
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
    public function actions(NovaRequest $request)
    {
        return array_merge(
            static::getGlobalActions(),
            []);
    }
}
