<?php

namespace App\Repositories;

use App\Models\Proposal;
use App\Models\Taxonomy;
use JetBrains\PhpStorm\Pure;

class ProposalRepository extends Repository
{
    // Constructor to bind model to repo
    #[Pure]
    public function __construct(Proposal $model)
    {
        parent::__construct($model);
    }

       // get the record with the given id
       public function get($idOrSlug, ...$params)
       {
           if (is_int($idOrSlug)) {
               return $this->model->findOrFail($idOrSlug);
           }

           return $this->model->where('slug', '=', $idOrSlug)->firstOrFail();
       }

       public function fundedCount($scope = null)
       {
           if ((bool) $scope) {
               $query = $this->getModel()->{$scope}();
           } else {
               $query = $this->getModel();
           }

           return $query->count();
       }

       /**
        * @param $scope
        */
       public function count($scope = null)
       {
           if ((bool) $scope) {
               $query = $this->getModel()->{$scope}();
           } else {
               $query = $this->getModel();
           }

           return $query->count();
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
               $this->query = Proposal::whereRaw('1=1');
           }

           return parent::inTaxonomies($taxonomyClass, $taxonomies);
       }
}
