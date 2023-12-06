<?php

namespace App\Nova;

use App\Models\Post;
use App\Models\Tx;
use App\Nova\Actions\MintNft;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Txs extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Tx::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'hash';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Store';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'hash',
        'policy',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Hash'))->sortable(),
            BelongsTo::make('Author', 'author', User::class)->searchable()->hideFromIndex(),
            Text::make(__('Policy'), 'policy')->hideFromIndex(),
            Text::make(__('Address')),
            Number::make(__('Quantity')),
            MorphTo::make('model')->types([
                Articles::class,
                Reviews::class,
                Podcasts::class,
                Nfts::class,
                Withdrawals::class,
            ])->searchable()->nullable(),
            Select::make(__('Status'), 'status')
                ->sortable()
                ->default('pending')
                ->rules(['required'])
                ->options([
                    'draft' => 'Draft',
                    'pending' => 'Pending',
                    'minting' => 'Minting',
                    'minted' => 'Minted',
                    'burnt' => 'Burnt',
                    'blacklisted' => 'Blacklisted',
                ]),
            DateTime::make(__('Minted At'), 'minted_at'),
            KeyValue::make('Metadata', 'metadata')->rules('json')->resolveUsing(function ($object) {
                return collect($object)?->sortKeys();
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
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(NovaRequest $request): array
    {
        return array_merge(
            static::getGlobalActions(),
            [
                (new MintNft),
                ExportAsCsv::make()->nameable(),
            ]
        );
    }
}
