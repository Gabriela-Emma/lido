<?php

namespace App\Nova;

use App\Models\LearningLesson;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Actions\ExportAsCsv;

class LearningLessons extends Resource
{
    /**
     * The model the resource corresponds to.
     */
    public static string $model = LearningLesson::class;

    public static $group = 'Learning';

    public static $perPageOptions = [25, 50, 100, 250];

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
        'title',
    ];

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        $query->withoutGlobalScopes([PublishedScope::class]);

        return parent::indexQuery($request, $query);
    }

    /**
     * Get the fields displayed by the resource.
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
            Number::make(__('Length'), 'length')->nullable(),
            Select::make(__('Difficulty'), 'difficulty')->options([
                'Beginner' => 'beginner',
                'Intermediate' => 'intermediate',
                'Advance' => 'advance',
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
            BelongsToMany::make(__('Learning Topics'), 'topics', LearningTopics::class)
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

        return array_merge(
            static::getGlobalActions(),
            [
                ExportAsCsv::make()->nameable(),
            ]
        );
    }
}
