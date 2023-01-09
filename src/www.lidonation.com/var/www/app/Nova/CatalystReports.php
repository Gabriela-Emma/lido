<?php

namespace App\Nova;

use App\Models\CatalystReport;
use App\Models\TwitterAttendance;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class CatalystReports extends Resource
{
    public static $group = 'Catalyst';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = CatalystReport::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 9;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'content',
        'token_utility',
        'community_size',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('proposal', 'proposal', Proposals::class),
            Text::make('project_status')->nullable(),
            Text::make('on_track')->nullable(),
            Text::make('token_launching')->nullable(),
            Text::make('token_utility')->hideFromIndex()->nullable(),
            Text::make('community_size')->nullable(),
            Text::make('circle_feedback')->nullable(),
            Text::make('completion_target')->nullable(),
            Text::make('attachment'),
            Markdown::make('content')->hideFromIndex()->nullable(),
            Markdown::make('off_track_reason')->nullable(),
            new Panel('Meta', $this->metaDataFields()),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request): array
    {
        return [
            (new AddMetaData),
            (new EditMetaData(TwitterAttendance::class)),
        ];
    }

    public function metaDataFields(): array
    {
        $modelObj = TwitterAttendance::find(request()->resourceId);

        if (! isset($modelObj)) {
            return [];
        }

        return $modelObj->metas->map(function ($meta) {
            return Text::make(Str::title($meta->key), $meta->key)
                ->resolveUsing(fn () => $meta->content)
                ->onlyOnDetail();
        })->all();
    }
}
