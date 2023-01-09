<?php

namespace App\Repositories;

use App\Models\Cause;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\Pure;

class CauseRepository extends Repository
{
    // Constructor to bind model to repo
    #[Pure]
    public function __construct(Cause $model)
    {
        parent::__construct($model);
    }

       /**
        * @param $scope
        */
       public function causes($scope = null): array|Collection
       {
           if ((bool) $scope) {
               return $this->getModel()::{$scope}()->get();
           }

           return $this->all();
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
               $this->query = Cause::whereRaw('1=1');
           }

           return parent::inTaxonomies($taxonomyClass, $taxonomies);
       }
}
