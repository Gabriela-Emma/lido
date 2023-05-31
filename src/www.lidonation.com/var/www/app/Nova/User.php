<?php

namespace App\Nova;

use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use App\Nova\Actions\FetchDelegation;
use App\Nova\Actions\PopulatePaymentAddress;
use App\Nova\Lenses\LidoDelegators;
use App\Nova\Metrics\Delegation;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    public static $group = 'People';

    /**
     * Custom priority level of the resource.
     *
     * @var int
     */
    public static $priority = 999991;

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
        'id', 'name', 'email', 'wallet_stake_address',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50),

            Images::make('Bio Pic', 'profile')
                ->conversionOnIndexView('thumbnail'),

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

            Text::make('Email')
                ->sortable()->withMeta(
                    [
                        'extraAttributes' => [
                            'autocomplete' => 'off',
                        ],
                    ]
                )
                ->required()
                ->rules('email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Select::make(__('Lang'), 'lang')->options(function () {
                return collect(config('laravellocalization.supportedLocales'))->mapWithKeys(fn ($lang) => ([$lang['key'] => $lang['native']]))->toArray();
            }),
            Password::make('Password')
                ->onlyOnForms()->withMeta(
                    [
                        'extraAttributes' => [
                            'autocomplete' => 'off',
                        ],
                    ]
                )
                ->creationRules('string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            BelongsTo::make('Primary Account', 'currentTeam', User::class)->nullable()->searchable(),

            new Panel('Bio', [
                Markdown::make('Short Bio')
                    ->hideFromIndex()
                    ->help('less than 24 words; will appear in author widget on articles. If Empty first 20 words of "Bio" will be used'),
                Markdown::make('Bio')
                    ->hideFromIndex()
                    ->help('content for the about us page.'),
            ]),

            //            BelongsTo::make('Current Team', 'currentTeam', Teams::class)->searchable(),

            new Panel('Meta', $this->metaDataFields()),

            new Panel('Stake Profile', $this->stakeProfile()),



            HasMany::make('Rewards', 'rewards', Rewards::class),

            HasMany::make('Quiz Responses', 'quiz_responses', AnswerResponses::class),

            HasMany::make('Mints', 'mint_txs', MintTxs::class),

            BelongsToMany::make(__('Teams'), 'teams', Teams::class)
                ->hideFromIndex()
                ->searchable(),

            BelongsToMany::make(__('Roles'), 'roles')
                ->hideFromIndex()
                ->searchable()->fields(function () {
                    return [
                        Text::make(__('Model'), 'model_type')
                            ->default(function (NovaRequest $request) {
                                return $request->model()::class;
                            }),
                    ];
                }),

            BelongsToMany::make(__('Permissions'), 'permissions')
                ->hideFromIndex()
                ->searchable()->fields(function () {
                    return [
                        Text::make(__('Model'), 'model_type')
                            ->default(function (NovaRequest $request) {
                                return $request->model()::class;
                            }),
                    ];
                }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            new Delegation(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array
    {
        return [
            new LidoDelegators(),
        ];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(Request $request): array
    {
        return [
            (new AddMetaData),
            (new EditMetaData(\App\Models\User::class)),
            (new PopulatePaymentAddress)->confirmText('Check skip, to skip updating wallet_address field on models that already have one!'),
            (new FetchDelegation),
        ];
    }

    public function stakeProfile(): array
    {
        return [
            Text::make('Stake Address', 'wallet_stake_address')
                ->sortable(),
            Text::make('Wallet Address', 'wallet_address')
                ->sortable(),
        ];
    }

    public function metaDataFields(): array
    {
        $metaFields = [
            Text::make('Facebook Username', 'facebook_user')
                ->help('username only.')
                ->resolveUsing(fn () => $this->metas?->firstWhere('key', 'facebook_user')?->content)
                ->hideWhenCreating(),
            Text::make('LinkedIn Username', 'linkedin_user')
                ->help('username only.')
                ->resolveUsing(fn () => $this->metas?->firstWhere('key', 'linkedin_user')?->content)
                ->hideWhenCreating(),
            Text::make('Twitter Handler')
                ->resolveUsing(fn () => $this->metas?->firstWhere('key', 'twitter_handler')?->content)
                ->help('username only.')
                ->hideWhenCreating(),
        ];
        $modelObj = \App\Models\User::find(request()->resourceId);
        if (! isset($modelObj)) {
            return $metaFields;
        }

        return $modelObj->metas->map(function ($meta) {
            return Text::make(Str::title(Str::replace('_', ' ', $meta->key)))
                ->resolveUsing(fn () => $meta->content)
                ->hideFromIndex()
                ->exceptOnForms();
        })->concat(collect($metaFields))->all();
    }
}
