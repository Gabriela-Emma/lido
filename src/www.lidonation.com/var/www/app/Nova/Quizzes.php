<?php

namespace App\Nova;

use App\Models\EveryEpoch;
use App\Models\Quiz;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphedByMany;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class Quizzes extends Resource
{
    public static $group = 'Quizzes';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Quiz::class;

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
            Text::make(__('Title')),
            Select::make(__('Status'), 'status')
                ->options([
                    'published' => 'Published',
                    'draft' => 'Draft',
                    'pending' => 'Pending',
                    'ready' => 'Ready',
                    'scheduled' => 'Scheduled',
                ])->default('published')->sortable(),
            Markdown::make(__('Content'), 'content')->translatable()->alwaysShow(),

            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable(),

            Images::make(__('Hero'), 'hero')
                ->enableExistingMedia(),

//            BelongsToMany::make(__('Models'), 'models', Mod::class)
//                ->searchable(),

//            MorphedByMany::make(__('Models'), 'models')->types([
//                Rating::class,
//            ]),

            BelongsToMany::make(__('Questions'), 'questions', Questions::class)
                ->searchable(),

            BelongsToMany::make(__('Giveaways'), 'giveaways', Giveaways::class)
                ->fields(function () {
                    return [
                        Text::make('Type', 'model_type')->default(Quiz::class)->onlyOnForms(),
                    ];
                })->searchable(),

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
                (new EditMetaData(\App\Models\Quiz::class)),
            ]);
    }
}
