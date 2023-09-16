<?php

namespace App\Nova;

use App\Models\TwitterAttendance;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Laravel\Nova\Actions\ExportAsCsv;

class TwitterAttendances extends Resource
{
    public static $group = 'Events';

    /**
     * The model the resource corresponds to.
     */
    public static string $model = TwitterAttendance::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'twitter_user_id';

    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 18;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'twitter_user_id',
        'twitter_event_id',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('twitter_user_id'),
            Text::make('twitter_event_id')->onlyOnForms(),
            Text::make('stake_address')->nullable(),
            Text::make('role')->nullable(),
            BelongsTo::make('twitter_event', 'twitter_event', TwitterEvents::class),
            DateTime::make('created_at')->onlyOnDetail(),
            DateTime::make('updated_at')->onlyOnDetail(),
            DateTime::make('deleted_at')->onlyOnDetail(),
            BelongsTo::make('author', 'author', User::class)->onlyOnForms()->nullable()->searchable(),
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
            (new AddMetaData),
            (new EditMetaData(TwitterAttendance::class)),
            ExportAsCsv::make()->nameable(),
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

        //        return $modelObj->metas?->map(fn ($meta) => Text::make(Str::title($meta->key))
        //            ->resolveUsing(fn () => $this->metas?->firstWhere('key', $meta->key)?->content)
        //            ->hideFromIndex()
        //            ->exceptOnForms()
        //        )->all();
    }
}
