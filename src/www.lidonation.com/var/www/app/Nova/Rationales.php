<?php

namespace App\Nova;

use App\Models\Assessment;
use App\Nova\Actions\PublishModel;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Rationales extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Assessment::class;

    public static $perPageViaRelationship = 25;

    public static $group = 'Catalyst';

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
            Gravatar::make('Avatar', 'email')->maxWidth(50),
            Text::make(__('Name'))->readonly(),
            Text::make(__('Email'))->readonly(),
            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable()
                ->nullable(),
            HasOne::make(__('Rating'), 'rating', Rating::class)
                ->nullable(),
            BelongsTo::make(__('Posted To'), 'model', Articles::class)
                ->searchable()
                ->nullable(),
            Select::make(__('Status'), 'status')->options([
                'published' => 'Published',
                'draft' => 'Draft',
                'pending' => 'Pending',
            ]),
            BelongsTo::make(__('Parent'), 'parent', self::class)
                ->nullable()->searchable()->hideFromIndex()->hideWhenUpdating(),
            Text::make(__('Title')),
            Stack::make('Details', [
                Text::make(__('Title'), 'title'),
                Slug::make(__('Summary'), 'summary'),
            ])->readonly(),
            Markdown::make(__('Content'), 'content')->sortable(),

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
                (new PublishModel),
                ExportAsCsv::make()->nameable(),
            ]);
    }
}
