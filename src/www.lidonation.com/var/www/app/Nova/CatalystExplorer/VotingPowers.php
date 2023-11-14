<?php

namespace App\Nova\CatalystExplorer;

use App\Models\CatalystExplorer\CatalystVotingPower;
use App\Nova\Actions\GenerateVoterHistory;
use App\Nova\Filters\FundSnapshot;
use App\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class VotingPowers extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = CatalystVotingPower::class;

    public static $group = 'Catalyst';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'voter_id', 'catalyst_snapshot_id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Voter Id '), 'voter_id')->sortable(),

            Text::make(__('Snapshot Id '), 'catalyst_snapshot_id')->sortable(),

            Text::make(__('Voting Power'), 'voting_power')->sortable(),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            (new FundSnapshot),
        ];
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
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            (new GenerateVoterHistory),
        ];
    }
}
