<?php

namespace App\Nova;

use App\Models\Team;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\AttachLink;
use App\Nova\Actions\EditMetaData;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Laravel\Nova\Actions\ExportAsCsv;

class Teams extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Team::class;

    public static $group = 'Catalyst';

    public static $perPageViaRelationship = 50;

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
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Name')),
            Images::make('Logo', 'logo')
                ->conversionOnIndexView('thumbnail'),
            BelongsTo::make(__('Owner'), 'owner', User::class)
                ->searchable(),
            Boolean::make(__('Personal Team')),

            new Panel('Content', self::contentFields()),
            new Panel('Meta', $this->metaDataFields()),

            BelongsToMany::make(__('Members'), 'users', User::class)
                ->hideFromIndex()
                ->searchable(),

            BelongsToMany::make(__('Links'), 'links')
                ->hideFromIndex()
                ->searchable()->fields(function () {
                    return [
                        Text::make(__('Model'), 'model_type')
                            ->default(function (NovaRequest $request) {
                                return $request->model()::class;
                            }),
                    ];
                }),
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
            (new AddMetaData),
            (new EditMetaData(Team::class)),
            (new AttachLink),
            ExportAsCsv::make()->nameable(),
        ];
    }

    public function metaDataFields(): array
    {
        $modelObj = Team::find(request()->resourceId);
        if (! isset($modelObj)) {
            return [];
        }

        return $modelObj->metas?->map(function ($meta) {
            return Text::make(Str::title($meta->key))
                ->resolveUsing(fn () => $this->metas?->firstWhere('key', $meta->key)?->content)
                ->hideFromIndex()
                ->exceptOnForms();
        })->all() ?? [];
    }

    public static function contentFields(): array
    {
        return [
            Markdown::make(__('Excerpt'), 'excerpt')
                ->help(
                    '2 to 3 sentence summary for listing pages on the site.'
                )->nullable(),
            Markdown::make(__('Content'), 'content'),
        ];
    }
}
