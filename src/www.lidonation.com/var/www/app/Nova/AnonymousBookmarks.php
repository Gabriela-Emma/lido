<?php

namespace App\Nova;

use App\Models\AnonymousBookmark;
use App\Models\Fund;
use App\Nova\Metrics\AnonymousBookmarkTrend;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Laravel\Nova\Actions\ExportAsCsv;


class AnonymousBookmarks extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = AnonymousBookmark::class;

    public static $group = 'Catalyst';

    public static $perPageViaRelationship = 25;

    //    public static $with = ['proposals', 'parent'];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static $perPageOptions = [25, 50, 100, 250];

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

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        $query->withoutGlobalScopes([PublishedScope::class]);

        return parent::indexQuery($request, $query);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            DateTime::make('Created At')
                ->help('Defaults to today. ')
                ->hideWhenUpdating()
                ->sortable(),

            Code::make('Bookmark'),

            new Panel('Meta', $this->metaDataFields()),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            new AnonymousBookmarkTrend,
        ];
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
            ]
        );
    }

    public function metaDataFields(): array
    {
        $modelObj = Fund::find(request()->resourceId);
        if (! isset($modelObj)) {
            return [];
        }

        return $modelObj->metas->map(
            fn ($meta) => Text::make(Str::title($meta->key))
                ->resolveUsing(fn () => $this->metas?->firstWhere('key', $meta->key)?->content)
                ->hideFromIndex()
                ->exceptOnForms()
        )->all();
    }
}
