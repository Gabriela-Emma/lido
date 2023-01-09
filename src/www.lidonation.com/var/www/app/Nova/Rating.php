<?php

namespace App\Nova;

use App\Nova\Actions\PublishModel;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class Rating extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Rating::class;

    public static $perPageViaRelationship = 25;

    public static $group = 'Meta Data';

    public static $perPageOptions = [25, 50, 100, 250, 500];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title(): string
    {
        $arrayModelType = explode('\\', $this->model->model_type);
        $modelType = end($arrayModelType);

        return "{$this->id}:{$modelType}"; //$this->metas->where('id', "=", $this->id);
    }

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        $query->withoutGlobalScopes([PublishedScope::class]);

        return parent::indexQuery($request, $query);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Number::make(__('Rating'))->sortable(),
            BelongsTo::make(__('Comment'), 'comment', Rationales::class)
                ->searchable()
                ->nullable(),
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
            HasMany::make('Metadata', 'metas', Metas::class),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  Request  $request
     * @return array
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function actions(Request $request): array
    {
        return array_merge(
            static::getGlobalActions(),
            [
                (new PublishModel),
            ]);
    }
}
