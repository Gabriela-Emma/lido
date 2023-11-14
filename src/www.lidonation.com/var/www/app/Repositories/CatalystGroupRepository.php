<?php

namespace App\Repositories;

use App\Models\CatalystExplorer\Group;
use App\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CatalystGroupRepository extends Repository
{
    // Constructor to bind model to repo
    public function __construct(Group $model)
    {
        parent::__construct($model);
    }

    // get the record with the given id
    public function get($idOrSlug, ...$params): Model|Builder
    {
        $this->buildQuery()->with([
            //            'challenges' => function ($query) {
            //                $query->groupBy('catalyst_group_has_catalyst_user.catalyst_group_id')
            //                    ->groupBy('proposals.id');
            //            },
            //            'proposals' => function ($query) {
            //                $query->groupBy('catalyst_group_has_catalyst_user.catalyst_group_id')
            //                    ->groupBy('proposals.id');
            //            },
            'proposals.discussions.ratings',
        ]);
        if (intval($idOrSlug) > 0) {
            $this->query->where('id', $idOrSlug);
        } else {
            $this->query->where('slug', '=', $idOrSlug);
        }

        return $this->query->firstOrFail();
    }

    /**
     * @param  null  $scope
     */
    public function users($scope = null): array|Collection
    {
        if ((bool) $scope) {
            return $this->getModel()::{$scope}()->get();
        }

        return $this->all();
    }

    public function buildQuery(): Builder
    {
        $this->query = $this->model
//            ->cacheFor(HOUR_IN_SECONDS)
            ->withCount([
                'proposals as alltime_proposals_completed' => function ($query) {
                    $query->where('status', '=', 'complete')
                        ->orWhere('status', '=', 'launched');
                }, ])
            ->withCount([
                'proposals as alltime_proposals_approved' => function ($query) {
                    $query->whereNotNull('funded_at');
                }, ])
            ->withSum([
                'proposals as alltime_funding_amount_approved' => function ($query) {
                    $query->whereNotNull('funded_at');
                }, ],
                'amount_requested')
            ->withSum([
                'proposals as alltime_funding_amount_received' => function ($query) {
                    $query->whereNotNull('funded_at');
                }, ],
                'amount_received')
            ->withSum('proposals as alltime_funding_amount_requested', 'amount_requested');

        //            ->withAvg([
        //                'proposals.discussions.ratings as rating' => function ($query) {
        //                    $query->whereNotNull('funded_at');
        //                }], 'rating');

        return $this->query;
    }
}
