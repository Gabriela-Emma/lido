<?php

namespace App\Repositories;

use App\Models\Fund;
use App\Models\Taxonomy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use JetBrains\PhpStorm\Pure;

class FundRepository extends Repository
{
    // Constructor to bind model to repo
    #[Pure]
    public function __construct(Fund $model)
    {
        parent::__construct($model);
    }

    /**
     * @param  null  $scope
     * @return array|Collection
     */
    public function funds($scope = null): array|Collection
    {
        if ($scope) {
            return $this->getModel()::{$scope}()->get();
        }

        return $this->all();
    }

    /**
     * @param  null  $scope
     * @return HigherOrderBuilderProxy|mixed
     */
    public function proposals($scope = null)
    {
        $query = $this->getModel()::with(['proposals']);
        if ((bool) $scope) {
            $query->{$scope}();
        }

        return $query->proposals;
    }

    /**
     * @param  Fund  $fund
     * @return Collection|Builder[]
     */
    public function fundChallenges(Fund $fund): Collection|array
    {
        return $this->getModel()::where('parent_id', $fund->id)->get();
    }

    /**
     * @param  null  $scope
     * @return mixed
     */
    public function proposalsCount($scope = null)
    {
        $query = $this->getModel()::withCount(['proposals']);
        if ((bool) $scope) {
            $query->{$scope}();
        }

        return $query->get()->sum(fn ($fund) => $fund->proposals->count());
    }

    /**
     * @param ...$taxonomies
     * @return mixed
     * Return posts in passed taxonomy class.
     * If no taxonomy is passed, you may pass mixed taxonomy types if passing in objects
     */
    public function inTaxonomies(string $taxonomyClass = null, ...$taxonomies): mixed
    {
        if (! isset($this->query)) {
            $this->query = Fund::whereRaw('1=1');
        }

        return parent::inTaxonomies($taxonomyClass, $taxonomies);
    }
}
