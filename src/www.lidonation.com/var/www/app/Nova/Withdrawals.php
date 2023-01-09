<?php

namespace App\Nova;

use App\Models\Nft;
use App\Models\Withdrawal;
use App\Nova\Actions\CacheNftImage;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class Withdrawals extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Withdrawal::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'wallet_address';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Lido Rewards';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'wallet_address',
        'user.wallet_stake_address',
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
            Text::make(__('Address'), 'wallet_address'),
            BelongsTo::make('User', 'user', User::class)->searchable()->hideFromIndex(),
            Select::make(__('Status'), 'status')
                ->sortable()
                ->default('pending')
                ->rules(['required'])
                ->options([
                'minting' => 'Processing',
                'validated' => 'Validated',
                'paid' => 'Paid',
                'minted' => 'Sending',
                'burnt' => 'Sent',
            ]),
            DateTime::make(__('Created At'), 'created_at'),
            HasMany::make('Metadata', 'metas', Metas::class),
            HasMany::make('Rewards', 'rewards', Rewards::class),
            HasMany::make('Transactions', 'txs', Txs::class)
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request): array
    {
        return array_merge(
            static::getGlobalActions(),
            [
                new CacheNftImage
            ]);
    }
}
