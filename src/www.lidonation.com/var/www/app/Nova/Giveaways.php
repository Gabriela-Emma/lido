<?php

namespace App\Nova;

use App\Models\Giveaway;
use App\Models\Question;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\DispersePoolRewards;
use App\Nova\Actions\EditMetaData;
use App\Nova\Actions\IssuePoolRewards;
use App\Nova\Actions\RecalculateRewards;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class Giveaways extends Resource
{
    public static $group = 'Quizzes';

    /**
     * The model the resource corresponds to.
     */
    public static string $model = Giveaway::class;

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
            Text::make(__('Meta Title'), 'meta_title')->translatable(),
            Text::make(__('Type')),
            //            MorphTo::make(__('Model'), 'model')
            //                ->types([
            //                    Articles::class,
            //                    EveryEpochs::class,
            //                    Quizzes::class
            //                ])->searchable(),
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

            Images::make(__('Hero'), 'hero')
                ->enableExistingMedia(),

            KeyValue::make('Transaction Metadata', 'tx_metadata')->rules('json')
                ->resolveUsing(function ($object) {
                    return collect($object)?->sortKeys();
                }),

            Markdown::make(__('Social Excerpt'), 'social_excerpt')->translatable()->alwaysShow(),
            Markdown::make(__('Content'), 'content')->translatable()->alwaysShow(),

            BelongsToMany::make(__('Wallets'), 'wallets', Wallets::class)->fields(function () {
                return [
                    Text::make('Type', 'model_type')->default(Giveaway::class)->onlyOnForms(),
                ];
            })->searchable(),

            HasMany::make('Rewards', 'rewards', Rewards::class),

            HasMany::make('Rules', 'rules', Rules::class),
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
    public function actions(Request $request): array
    {
        return array_merge(
            static::getGlobalActions(),
            [
                (new AddMetaData),
                (new EditMetaData(Question::class)),
                (new RecalculateRewards),
                (new IssuePoolRewards)->onlyOnDetail(),
                (new DispersePoolRewards)->onlyOnDetail(),
                ExportAsCsv::make()->nameable(),
            ]);
    }
}
