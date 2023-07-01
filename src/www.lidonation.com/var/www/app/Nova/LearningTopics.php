<?php

namespace App\Nova;

use App\Models\Giveaway;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\LearningTopic;

class LearningTopics extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = LearningTopic::class;

    public static $group = 'Learning';

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

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Title'), 'title')
                ->translatable()
                ->required(),
            Markdown::make(__('Content'), 'content')->translatable()->required(),

            Select::make(__('Difficulty'), 'difficulty')->options([
                'Beginner' => 'beginner',
                'Intermediate' => 'intermediate',
                'Advance' => 'advance',
            ])->required(),

            Select::make(__('Status'), 'status')->options([
                'published' => 'Published',
                'draft' => 'Draft',
            ])->required(),

            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable(),


            BelongsToMany::make(__('Giveaways'), 'giveaways', Giveaways::class)
                ->fields(function () {
                    return [
                        Text::make('Type', 'model_type')->default(LearningTopic::class)->onlyOnForms(),
                    ];
                })
                ->hideFromIndex()
                ->searchable(),

            BelongsToMany::make(__('Learning Modules'), 'learningModules', LearningModules::class)
                ->hideFromIndex()
                ->searchable(),

            BelongsToMany::make(__('Learning Lesson'), 'learningLessons', LearningLessons::class)
                ->hideFromIndex()
                ->searchable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
