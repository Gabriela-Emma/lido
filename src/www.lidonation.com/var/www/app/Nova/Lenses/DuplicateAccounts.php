<?php

namespace App\Nova\Lenses;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;

class DuplicateAccounts extends Lens
{
    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return $request->withOrdering($request->withFilters(
            $query->includeDuplicates()->whereNotNull('primary_account_id')
        ));
    }

    /**
     * Get the fields available to the lens.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Gravatar::make()->maxWidth(50),
            Images::make('Bio Pic', 'profile')
                ->conversionOnIndexView('thumbnail'),
            Text::make('NAME'),
            Text::make('EMAIL'),
            Text::make('LANG'),
            Text::make('Primary Account', 'primary_account')
                ->nullable()
                ->displayUsing(function ($user) {
                    return $user?->name;
                }),
            Text::make('FACEBOOK USERNAME'),
            Text::make('LINKEDIN'),
            Text::make('TWITTER HANDLER'),
            Text::make('STAKE ADDRESS'),
            Text::make('WALLET ADDRESS'),
        ];
    }

    /**
     * Get the cards available on the lens.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the lens.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available on the lens.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'duplicate-accounts';
    }
}
