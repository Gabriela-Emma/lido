<?php

namespace App\Nova;

use App\Models\CatalystGroup;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use App\Nova\Actions\SyncCatalystGroupProposals;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class CatalystGroups extends Resource
{
    /**
     * The model the resource corresponds to.
     */
    public static string $model = CatalystGroup::class;

    public static $group = 'Catalyst';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'bio',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()->withMeta(
                    [
                        'extraAttributes' => [
                            'autocomplete' => 'off',
                        ],
                    ]
                )
                ->required()
                ->rules('max:255'),

            Text::make('Slug'),

            Images::make(__('Hero'), 'hero')
                ->enableExistingMedia(),

            new Panel('Bio', [
                Markdown::make('Bio')
                    ->hideFromIndex()
                    ->translatable()
                    ->help('Group or company bio.'),
            ]),

            URL::make('Website')
                ->hideFromIndex()
                ->rules('url')
                ->required()
                ->help('Secure website URL. Insecure links will be removed.'),

            URL::make('Discord')
                ->hideFromIndex()
                ->help('Discord server URL.'),

            URL::make('Github')
                ->hideFromIndex()
                ->help('Github Or Page.'),

            Text::make('Twitter')
                ->hideFromIndex()
                ->help('@username only'),

            HasMany::make('Metadata', 'metas', Metas::class),

            BelongsTo::make(__('Owner'), 'owner', CatalystUsers::class)
                ->searchable(),

            BelongsToMany::make(__('Members'), 'members', CatalystUsers::class)
                ->searchable()
                ->hideFromIndex(),

            BelongsToMany::make(__('Challenges'), 'challenges', Proposals::class)
                ->hideFromIndex(),

            BelongsToMany::make(__('Proposals'), 'proposals', Proposals::class)
                ->searchable()
                ->hideFromIndex(),

            Select::make(__('Status'), 'status')->options([
                'draft' => 'Draft',
                'pending' => 'Pending',
                'published' => 'Published',
            ]),
        ];
    }

    /**
     * Get the actions available for the resource.
     */
    #[Pure]
 public function actions(NovaRequest $request): array
 {
     return [
         (new AddMetaData),
         (new EditMetaData(CatalystGroup::class)),
         (new SyncCatalystGroupProposals),
     ];
 }
}
