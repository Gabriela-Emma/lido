<?php

namespace App\Nova;

use App\Models\Podcast;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class Podcasts extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Podcast::class;

    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 12;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

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
        'title',
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
            Text::make(__('Title'))->translatable(),
            Text::make(__('Meta Title'))->translatable(),
            Number::make(__('Episode Number'), 'episode'),
            Number::make(__('Length')),
            Text::make(__('YouTube ID'), 'youtube_id'),
            URL::make(__('Published Link'), 'published_link'),
            BelongsTo::make('Author', 'author', User::class)->searchable(),
            BelongsTo::make('Host', 'host', User::class)->searchable(),
            BelongsTo::make('Season', 'season', PodcastSeasons::class)->searchable(),
            BelongsTo::make('Show', 'show', PodcastShows::class)->searchable(),
            Select::make(__('Status'), 'status')->options([
                'draft' => 'Draft',
                'live' => 'Live',
                'completed' => 'Completed',
                'published' => 'Published',
                'canceled' => 'Cancelled',
            ])->sortable(),
            DateTime::make(__('Recorded At'), 'recorded_at'),
            DateTime::make(__('Published At'), 'published_at'),
            Markdown::make(__('Content'))->translatable(),
            Markdown::make(__('Excerpt'), 'social_excerpt')->translatable(),
            Markdown::make(__('Comment Prompt'), 'comment_prompt')->translatable(),
            HasMany::make('Nfts', 'nfts', Nfts::class),
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
            [
                ExportAsCsv::make()->nameable(),
            ]);
    }
}
