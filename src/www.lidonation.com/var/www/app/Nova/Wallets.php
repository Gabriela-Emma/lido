<?php

namespace App\Nova;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class Wallets extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Wallet::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'address';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    // public static $group = 'Phuffy';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'address',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Address'), 'address'),
            BelongsTo::make(__('User'))->searchable(),
            //            MorphedByMany::make('models', 'models', [Votes::class]),
            //            MorphTo::make(__('Attached to'), 'models')->types([
            //                Articles::class,
            //                EveryEpochs::class,
            //                Votes::class
            //            ]),
            Number::make(__('Lovelaces'), 'ada_balance'),
            //            Number::make(__('Token Balance'), 'token_balance'),
            Code::make(__('Verification Key'))->json()->onlyOnForms(),
            Code::make(__('Signing Key'))->json()->onlyOnForms(),
            Code::make(__('Passphrase'))->onlyOnForms(),
            Text::make(__('Context'), 'context'),
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
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            ExportAsCsv::make()->nameable(),
        ];
    }
}
