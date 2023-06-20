<?php

namespace App\Nova;

use App\Models\Quiz;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class Quizzes extends Resource
{
    public static $group = 'Quizzes';

    public static $perPageOptions = [50, 100, 250];

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
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return Str::limit(data_get($this, static::$title), 24);
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Title'))->translatable()->sortable(fn ($query) => $query->orderBy('attribute_title->'.app()->getLocale())
            ),
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
     */
    public function cards(Request $request): array
    {
        return [];
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
                (new EditMetaData(\App\Models\Quiz::class)),
            ]);
    }
}
