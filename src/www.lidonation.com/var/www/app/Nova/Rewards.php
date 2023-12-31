<?php

namespace App\Nova;

use App\Models\Question;
use App\Models\Reward;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\DispersePoolRewards;
use App\Nova\Actions\EditMetaData;
use App\Nova\Actions\IssueAdditionalRewards;
use App\Nova\Actions\RecalculateRewards;
use App\Nova\Metrics\RewardStatus;
use App\Nova\Metrics\UnpaidRewards;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class Rewards extends Resource
{
    public static $group = 'Lido Rewards';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'amount';

    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 25;

    public static $perPageOptions = [50, 100, 250];

    /**
     * The model the resource corresponds to.
     */
    public static string $model = Reward::class;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'asset',
        'stake_address',
        'memo',
        'user.name',
    ];

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
    ];

    /**
     * Get the value that should be displayed to represent the resource.
     */
    public function title(): string
    {
        return (string) data_get($this, 'asset');
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Date::make('Created At', 'created_at')->sortable(),

            BelongsTo::make(__('Recipient'), 'author', User::class)
                ->sortable()
                ->filterable()
                ->searchable(),

            BelongsTo::make(__('Withdrawal'), 'withdrawal', Withdrawals::class)
                ->sortable()
                ->searchable(),

            Text::make(__('Stake Address'), 'stake_address')
                ->filterable()
                ->sortable()
                ->displayUsing(function ($value) use ($request) {
                    if ($request->isResourceIndexRequest()) {
                        return Str::truncate($value, 16);
                    }

                    return $value;
                }),

            MorphTo::make(__('Model'), 'model')
                ->types([Giveaways::class, LearningLessons::class])
                ->searchable(),

            Select::make(__('Asset Type'), 'asset_type')
                ->filterable()
                ->options([
                    'ft' => 'Fungible Token',
                    'nft' => 'NFT',
                    'ada' => 'Ada',
                    'fiat' => 'Fiat',
                ])->default('ft')->sortable(),
            Text::make(__('Asset')),

            Text::make('tx')
                ->filterable(
                    fn ($request, $query, $value, $attribute) => $query->whereRelation('withdrawal.metas', 'content', $value)
                )
                ->displayUsing(function ($value) {
                    return $this->withdrawal?->meta_data?->withdrawal_tx;
                })
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Number::make(__('Amount'))->sortable(),

            Markdown::make(__('Memo'), 'memo')->translatable()->alwaysShow(),

            Select::make(__('Status'), 'status')
                ->options([
                    'draft' => 'Draft',
                    'pending' => 'Pending',
                    'issued' => 'Issued',
                    'processed' => 'Processed',
                    'paid' => 'Paid',
                    'claimed' => 'Claimed',
                    'expired' => 'Expired',
                ])
                ->filterable()
                ->default('draft')
                ->sortable(),

            HasMany::make('Transactions', 'txs', Txs::class),
        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array
    {
        return [
            (new UnpaidRewards),
            (new RewardStatus),
        ];
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
                (new EditMetaData(Question::class)),
                (new RecalculateRewards),
                (new IssueAdditionalRewards),
                (new DispersePoolRewards),
                ExportAsCsv::make()->nameable(),
            ]);
    }
}
