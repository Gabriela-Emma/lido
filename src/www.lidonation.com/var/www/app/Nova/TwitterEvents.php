<?php

namespace App\Nova;

use App\Models\TwitterEvent;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use App\Nova\Actions\PickGiveawayWinners;
use App\Nova\Actions\SyncWithTwitterSpaceApi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class TwitterEvents extends Resource
{
    public static $group = 'Events';

    /**
     * The model the resource corresponds to.
     */
    public static string $model = TwitterEvent::class;

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
        'title',
        'event_id',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('event_id')
                ->required()
                ->help('This is the only required field. Run Sync with Twitter action fill remaining fields after create.'),
            Text::make('title'),
            Text::make('creator_id'),
            Text::make('type')->default('space'),
            Text::make('status'),
            Text::make('event_post'),
            Number::make('Participants', 'participant_count'),
            Number::make('Subscriber Count', 'subscriber_count'),
            DateTime::make('scheduled_at'),
            DateTime::make('started_at'),
            DateTime::make('ended_at'),
            DateTime::make('created_at')->onlyOnDetail(),
            DateTime::make('updated_at')->onlyOnDetail(),
            DateTime::make('deleted_at')->onlyOnDetail(),
            BelongsTo::make('author', 'author', User::class)->onlyOnForms()->nullable()->searchable(),
            HasMany::make('attendances', 'attendances', TwitterAttendances::class),
            new Panel('Meta', $this->metaDataFields()),
        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(NovaRequest $request): array
    {
        return [
            new SyncWithTwitterSpaceApi,
            new PickGiveawayWinners,
            (new AddMetaData),
            (new EditMetaData(\App\Models\TwitterEvent::class)),
            ExportAsCsv::make()->nameable(),
        ];
    }

    public function metaDataFields(): array
    {
        $modelObj = TwitterEvent::find(request()->resourceId);

        if (! isset($modelObj)) {
            return [];
        }

        return $modelObj->metas->map(function ($meta) {
            return Text::make(Str::title($meta->key), $meta->key)
                ->resolveUsing(fn () => $meta->content)->onlyOnDetail();
        })->all();
    }
}
