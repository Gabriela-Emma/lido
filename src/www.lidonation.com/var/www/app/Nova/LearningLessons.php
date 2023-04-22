<?php

namespace App\Nova;

use App\Models\EveryEpoch;
use App\Models\LearningLesson;
use App\Scopes\LimitScope;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class LearningLessons extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = LearningLesson::class;

    public static $group = 'Learning';

    public static $perPageOptions = [50, 100, 250];

    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 25;

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
        'id',
        'title'
    ];

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        $query->withoutGlobalScopes([PublishedScope::class]);

        return parent::indexQuery($request, $query);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make(__('Title'), 'title')
                ->translatable()
                ->required(),
            Markdown::make(__('Content'), 'content')->translatable()->required(),
            Number::make(__('Order'), 'order')->required(),
            Number::make(__('Length'), 'length')->required(),
            Select::make(__('Difficulty'), 'difficulty')->options([
                'Beginner' => 'beginner',
                'Intermediate' => 'intermediate',
                'Advance' => 'advance'
            ])->required(),
            MorphTo::make('model')->types([
                News::class,
                Insights::class,
                Link::class,
                Podcasts::class,
            ])->searchable()->nullable(),
            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable(),
            Select::make(__('Status'), 'status')->options([
                'published' => 'Published',
                'draft' => 'Draft',
            ])->sortable()
                ->required(),
            BelongsToMany::make(__('Learning Topics'), 'topics', LearningTopic::class)
                ->hideFromIndex()
                ->searchable(),


            BelongsToMany::make(__('Quizzes'), 'quizzes', Quizzes::class)->fields(function () {
                return [
                    Text::make('Type', 'model_type')->default(LearningLesson::class)->onlyOnForms(),
                ];
            })->searchable(),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request): array
    {

        return array_merge(
            static::getGlobalActions(),
            [

            ]
        );
    }
}
