<?php

namespace App\Nova;

use App\Models\Vote;
use App\Scopes\OwnerScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Actions\ExportAsCsv;

class Votes extends Resource
{
    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     */
    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        $query->withoutGlobalScopes([OwnerScope::class]);

        return parent::indexQuery($request, $query);
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Vote::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'memo';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Phuffy';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'memo',
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
            Number::make(__('Amount'), 'amount'),
            BelongsTo::make(__('Cause'), 'cause', Causes::class)->searchable(),
            BelongsTo::make(__('User'))->searchable(),
            Text::make(__('Status'), 'status'),
            Text::make(__('Memo'), 'memo'),
            BelongsToMany::make(__('Wallets'), 'wallets', Wallets::class),
        ];

        Withdrawal::pending()
            ->with('rewards')
            ->get()->filter(fn ($w) => $w->rewards->count() < 6)
            ->each(function ($w) {
                $w->rewards->each(function ($r) {
                    $r->status = 'issued';
                    $r->withdrawal_id = null;
                    $r->save();
                });
            });
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
