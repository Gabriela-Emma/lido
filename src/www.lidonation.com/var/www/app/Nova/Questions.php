<?php

namespace App\Nova;

use App\Models\Question;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class Questions extends Resource
{
    public static $group = 'Quizzes';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = Question::class;

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
        'content',
    ];

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
            Text::make(__('Title'))->translatable()->sortable(),
            Text::make(__('Type')),
            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable(),
            Select::make(__('Status'), 'status')
                ->options([
                    'published' => 'Published',
                    'draft' => 'Draft',
                    'pending' => 'Pending',
                    'ready' => 'Ready',
                    'scheduled' => 'Scheduled',
                ])->default('published')->sortable(),

            Markdown::make(__('Content'), 'content')->translatable()->alwaysShow(),

            HasMany::make('Answers', 'answers', QuestionAnswers::class),

            BelongsToMany::make(__('Quizzes'), 'quizzes', Quizzes::class)
                ->searchable(),

            HasMany::make('Responses', 'responses', AnswerResponses::class),



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
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    #[Pure]
    public function actions(Request $request): array
    {
        return array_merge(
            static::getGlobalActions(),
            [
                (new AddMetaData),
                (new EditMetaData(\App\Models\Question::class)),
            ]);
    }
}
