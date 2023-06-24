<?php

namespace App\Nova;

use App\Invokables\TruncateValue;
use Laravel\Nova\Panel;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use App\Nova\Metrics\Delegation;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use App\Nova\Actions\AddMetaData;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Password;
use App\Nova\Actions\EditMetaData;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Lenses\LidoDelegators;
use App\Nova\Actions\FetchDelegation;
use App\Nova\Lenses\DuplicateAccounts;
use Laravel\Nova\Fields\BelongsToMany;
use App\Nova\Actions\SendVerificationEmail;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Actions\PopulatePaymentAddress;

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
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return Str::truncate(data_get($this, static::$title), 18);
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50),

            Text::make('Name')
                ->sortable()->withMeta(
                    [
                        'extraAttributes' => [
                            'autocomplete' => 'off',
                        ],
                    ]
                )
                ->displayUsing(new TruncateValue($request))
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

            Boolean::make('Email Verified', 'email_verified_at')
                ->sortable()
                ->filterable(
                    fn ($request, $query, $value, $attribute) => (bool) $value ? $query->whereNotNull('email_verified_at') : $query->whereNull('email_verified_at')
                )
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Boolean::make('Duplicate', 'primary_account_id')
                ->sortable()
                ->hideFromDetail()
                ->hideFromIndex()
                ->hide()
                ->filterable(
                    fn ($request, $query, $value, $attribute) => (bool) $value ? $query->whereNotNull('primary_account_id') : $query->whereNull('primary_account_id')
                )
                ->hideWhenCreating(),

            Select::make(__('Lang'), 'lang')->options(function () {
                return collect(config('laravellocalization.supportedLocales'))
                    ->mapWithKeys(
                        fn ($lang) => ([$lang['key'] => $lang['native']])
                    )->toArray();
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

            BelongsTo::make('Primary Account', 'primary_account', User::class)
                ->nullable()
                ->searchable(),

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

            new Panel('Stake Profile', $this->stakeProfile($request)),

            HasMany::make('Duplicate Accounts', 'duplicate_accounts', User::class),

            HasMany::make('Rewards', 'rewards', Rewards::class),

            HasMany::make('Quiz Responses', 'quiz_responses', AnswerResponses::class),

            HasMany::make('Mints', 'mint_txs', MintTxs::class),

            BelongsToMany::make(__('Teams'), 'teams', Teams::class)
                ->hideFromIndex()
                ->searchable(),

            BelongsToMany::make(__('Roles'), 'roles')
                ->hideFromIndex()
                ->filterable()
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
            new LidoDelegators(), new DuplicateAccounts(),
        ];
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
                (new EditMetaData(\App\Models\User::class)),
                (new SendVerificationEmail),
                (new PopulatePaymentAddress)->confirmText('Check skip, to skip updating wallet_address field on models that already have one!'),
                (new FetchDelegation),
            ]
        );
    }

    public function stakeProfile(Request $request): array
    {
        return [
            Text::make('Stake Address', 'wallet_stake_address')
                ->displayUsing(new TruncateValue($request))
                ->sortable(),
            Text::make('Wallet Address', 'wallet_address')
                ->displayUsing(new TruncateValue($request))
                ->sortable(),
        ];
    }

    public function metaDataFields(): array
    {
        $metaFields = [
            Text::make('Facebook Username', 'facebook_user')
                ->help('username only.')
                ->resolveUsing(fn () => $this->metas?->firstWhere('key', 'facebook_user')?->content)
                ->hideWhenCreating()
                ->hideFromIndex(),
            Text::make('LinkedIn Username', 'linkedin_user')
                ->help('username only.')
                ->resolveUsing(fn () => $this->metas?->firstWhere('key', 'linkedin_user')?->content)
                ->hideWhenCreating()
                ->hideFromIndex(),
            Text::make('Twitter Handler')
                ->resolveUsing(fn () => $this->metas?->firstWhere('key', 'twitter_handler')?->content)
                ->help('username only.')
                ->hideFromIndex()
                ->hideWhenCreating(),
        ];
        $modelObj = \App\Models\User::find(request()->resourceId);
        if (!isset($modelObj)) {
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
