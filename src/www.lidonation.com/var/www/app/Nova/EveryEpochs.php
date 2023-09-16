<?php

namespace App\Nova;

use App\Models\EveryEpoch;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Actions\ExportAsCsv;

class EveryEpochs extends Resource
{
    public static $group = 'Quizzes';

    /**
     * The model the resource corresponds to.
     */
    public static string $model = EveryEpoch::class;

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
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Title'))->translatable()->sortable(),
            Number::make(__('Epoch'))->sortable(),
            Select::make(__('Status'), 'status')
                ->options([
                    'published' => 'Published',
                    'draft' => 'Draft',
                    'pending' => 'Pending',
                    'ready' => 'Ready',
                    'scheduled' => 'Scheduled',
                ])->default('published')->sortable(),

            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable(),

            Markdown::make(__('Content'), 'content')->translatable()->alwaysShow(),

            BelongsToMany::make(__('Quizzes'), 'quizzes', Quizzes::class)->fields(function () {
                return [
                    Text::make('Type', 'model_type')->default(EveryEpoch::class)->onlyOnForms(),
                ];
            })->searchable(),

            BelongsToMany::make(__('Giveaways'), 'giveaways', Giveaways::class)
                ->fields(function () {
                    return [
                        Text::make('Type', 'model_type')->default(EveryEpoch::class)->onlyOnForms(),
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
                (new EditMetaData(EveryEpoch::class)),
                ExportAsCsv::make()->nameable(),
            ]);
    }
}
