<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class LearningModule extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\LearningModule::class;

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
        'slug',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable(),
            // Slug::make(__('Slug'), 'slug')->displayUsing(fn ($name) => Str::limit($name, 35)),
            Text::make(__('Title'), 'title')
                ->translatable()
                ->required(),
            Markdown::make(__('Content'), 'content')->translatable()->required(),
            Select::make(__('Difficulty'), 'difficulty')->options([
                'Beginner' => 'beginner',
                'Intermediate' => 'intermediate',
                'Advance' => 'advance'
            ])->required(),
            Select::make(__('Status'), 'status')->options([
                'published' => 'Published',
                'draft' => 'Draft',
            ])->required(),
            
            BelongsToMany::make(__('Learning Topics'), 'learningTopics', LearningTopic::class)
            ->hideFromIndex()
            ->searchable(),
                    
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
