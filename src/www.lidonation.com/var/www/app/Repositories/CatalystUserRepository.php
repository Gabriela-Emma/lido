<?php

namespace App\Repositories;

use App\Models\CatalystExplorer\CatalystUser;
use Illuminate\Database\Eloquent\Collection;

class CatalystUserRepository extends Repository
{
    public function __construct(CatalystUser $model)
    {
        parent::__construct($model);
    }

    public function get($idOrSlug, ...$params)
    {
        $relation = 'proposals';
        if (count($params) > 0) {
            $relation = $params[0];
        }

        $this->query = $this->model
            ->with(["{$relation}.discussions.ratings"])
            ->withCount([
                "$relation as alltime_proposals_completed" => fn ($query) => $query->where('status', '=', 'complete')->orWhere('status', '=', 'launched'),
                //                'own_proposals as alltime_own_proposals_completed' =>
                //                    fn($query) => $query->where('status', '=', 'complete')->orWhere('status', '=', 'launched')
            ])
            ->withCount([
                "$relation as alltime_proposals_approved" => fn ($query) => $query->whereNotNull('funded_at'),
                //                'own_proposals as alltime_own_proposals_approved' => fn($query) => $query->whereNotNull('funded_at')
            ])
            ->withSum([
                "$relation as alltime_funding_amount_approved" => fn ($query) => $query->whereNotNull('funded_at'),
                //                'own_proposals as alltime_own_funding_amount_approved' => fn($query) => $query->whereNotNull('funded_at')
            ],
                'amount_requested')
            ->withSum([
                "$relation as alltime_funding_amount_received" => fn ($query) => $query->whereNotNull('funded_at'),
                //                'own_proposals as alltime_own_funding_amount_received' => fn ($query) => $query->whereNotNull('funded_at')
            ],
                'amount_received')
            ->withSum("$relation as alltime_funding_amount_requested", 'amount_requested');
        //            ->withSum('own_proposals as alltime_own_funding_amount_requested', 'amount_requested');
        //            ->withAvg([
        //                'proposals.discussions.ratings as rating' => function ($query) {
        //                    $query->whereNotNull('funded_at');
        //                }], 'rating');
        if (intval($idOrSlug) > 0) {
            $this->query->where('id', $idOrSlug);
        } else {
            $this->query->where('username', '=', $idOrSlug);
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
}
