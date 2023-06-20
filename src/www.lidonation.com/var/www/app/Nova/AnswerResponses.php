<?php

namespace App\Nova;

use App\Models\AnswerResponse;
use App\Models\Question;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use App\Nova\Metrics\QuizAnswerResponseVeracity;
use App\Nova\Metrics\QuizAttemptsPerDay;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;

class AnswerResponses extends Resource
{
    public static $group = 'Quizzes';

    /**
     * The model the resource corresponds to.
     */
    public static string $model = AnswerResponse::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    public static $perPageOptions = [50, 100, 250];

    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 25;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'answer',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Responses';
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Boolean::make('Correct', fn () => $this->correct),

            BelongsTo::make(__('Answer'), 'answer', QuestionAnswers::class)
                ->searchable(),

            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable(),

            Text::make(__('Stake Address')),

            //            Text::make('Answer', function () {
            //                return $this->answer?->content;
            //            })->onlyOnIndex(),

            Select::make(__('Status'), 'status')
                ->options([
                    'published' => 'Published',
                    'draft' => 'Draft',
                    'pending' => 'Pending',
                    'ready' => 'Ready',
                    'scheduled' => 'Scheduled',
                ])->default('published')->sortable(),

            BelongsTo::make(__('Quiz'), 'quiz', Quizzes::class)
                ->searchable(),

            BelongsTo::make(__('Question'), 'question', Questions::class)
                ->searchable(),
            HasMany::make('Metadata', 'metas', Metas::class),
        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array
    {
        return [
            new QuizAnswerResponseVeracity,
            new QuizAttemptsPerDay,
        ];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    #[Pure]
    public function actions(Request $request): array
    {
        return array_merge(
            static::getGlobalActions(),
            [
                (new AddMetaData),
                (new EditMetaData(Question::class)),
            ]);
    }
}
