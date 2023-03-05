<?php

namespace App\Nova\Lenses;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;

class PendingClaims extends Lens
{
    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return $query->whereHas('metas', function ($query) {
            $query->where('key', 'ideascale_verification_code')
                  ->whereNull('claimed_by');
        });
    }

    /**
     * Get the fields available to the lens.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
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

            Text::make('Email')
                ->sortable()->withMeta(
                    [
                        'extraAttributes' => [
                            'autocomplete' => 'off',
                        ],
                    ]
                ),
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
        return 'pending-claims';
    }
}
