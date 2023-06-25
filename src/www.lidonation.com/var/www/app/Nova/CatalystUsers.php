<?php

namespace App\Nova;

use App\Models\CatalystUser;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use App\Nova\Actions\ValidateClaims;
use App\Nova\Lenses\PendingClaims;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class CatalystUsers extends Resource
{
    /**
     * The model the resource corresponds to.
     */
    public static string $model = CatalystUser::class;

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
        'id', 'name', 'email', 'username',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
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
                ->rules('max:255')
                ->required(),

            Text::make('username')
                ->sortable()->withMeta(
                    [
                        'extraAttributes' => [
                            'autocomplete' => 'off',
                        ],
                    ]
                ),

            Text::make('ideascale Id')
                ->sortable()->withMeta(
                    [
                        'extraAttributes' => [
                            'autocomplete' => 'off',
                        ],
                    ]
                ),

            Text::make('Email')
                ->sortable()->withMeta(
                    [
                        'extraAttributes' => [
                            'autocomplete' => 'off',
                        ],
                    ]
                )
                ->required(),

            Images::make(__('Hero'), 'hero')
                ->enableExistingMedia(),

            new Panel('Bio', [
                Markdown::make('Bio')
                    ->hideFromIndex()
                    ->help('content for the about us page.'),
            ]),

            BelongsToMany::make(__('Groups'), 'groups', CatalystGroups::class)
                ->searchable(),

            HasMany::make('Metadata', 'metas', Metas::class),

            BelongsToMany::make(__('Challenges'), 'challenges', Proposals::class)
                ->searchable()
                ->hideFromIndex(),

            HasMany::make(__('Own Proposals'), 'own_proposals', Proposals::class)
                ->hideFromIndex(),

            HasMany::make(__('Team Proposals'), 'proposals', Proposals::class)
                ->hideFromIndex(),
        ];
    }

    /**
     * Get the actions available for the resource.
     */
    #[Pure]
 public function actions(Request $request): array
 {
     return [
         (new AddMetaData),
         (new EditMetaData(CatalystUser::class)),
         (new ValidateClaims),
     ];
 }

 public function lenses(NovaRequest $request)
 {
     return [
         (new PendingClaims),
     ];
 }
}
