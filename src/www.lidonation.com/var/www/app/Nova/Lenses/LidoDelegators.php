<?php

namespace App\Nova\Lenses;

use App\Services\CardanoBlockfrostService;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class LidoDelegators extends Lens
{
    /**
     * Get the query builder / paginator for the lens.
     *
     * @param LensRequest $request
     * @param Builder $query
     * @return Builder
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function query(LensRequest $request, $query): Builder
    {
        $poolId = config('cardano.pool.hash');
        $delegatorsAddresses = app(CardanoBlockfrostService::class)
            ->get('pools/'.$poolId.'/delegators', null)
            ->collect()
            ->pluck('address');

        return $request->withOrdering($request->withFilters(
            $query->whereIn('wallet_stake_address', $delegatorsAddresses)
        ));
    }

    /**
     * Get the fields available to the lens.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make('Name')
                ->sortable(),

            Text::make('Email')
                ->sortable(),
        ];
    }

    /**
     * Get the cards available on the lens.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available on the lens.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request): array
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey(): string
    {
        return 'lido-delegators';
    }
}
