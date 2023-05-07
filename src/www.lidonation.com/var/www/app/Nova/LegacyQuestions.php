<?php

namespace App\Nova;

use App\Models\Prompt;
use App\Nova\Actions\PublishModel;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class LegacyQuestions extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Prompt::class;

    public static $perPageViaRelationship = 25;

    public static $group = 'Meta Data';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    public static $perPageOptions = [25, 50, 100, 250, 500];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
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
            Text::make(__('Question'), 'title')->hideFromIndex(),
            Stack::make('Details', [
                Text::make(__('Question'), 'title'),
                Slug::make(__('Answer'), 'summary'),
            ])->readonly()->onlyOnIndex(),
            Markdown::make(__('Answer'), 'content'),

            Text::make(__('Model Type'), 'model_type')
                ->default(function (NovaRequest $request) {
                    return $request->model()::class;
                }),

            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable()
                ->nullable(),
            BelongsTo::make(__('Posted To'), 'model', Articles::class)
                ->searchable()
                ->nullable(),
            Select::make(__('Status'), 'status')->options([
                'published' => 'Published',
                'draft' => 'Draft',
                'pending' => 'Pending',
            ]),

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
            (new PublishModel),
        ];
    }
}
