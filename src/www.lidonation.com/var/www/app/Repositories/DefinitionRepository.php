<?php

namespace App\Repositories;

use App\Models\Definition;
use JetBrains\PhpStorm\Pure;

class DefinitionRepository extends Repository
{
    // Constructor to bind model to repo
    #[Pure]
    public function __construct(Definition $model)
    {
        parent::__construct($model);
    }

       // get the record with the given id
       public function get(mixed $idOrSlug, ...$params)
       {
           if (is_int($idOrSlug)) {
               return $this->model->findOrFail($idOrSlug);
           }

           return $this->model->where('slug', '=', $idOrSlug)->firstOrFail();
       }
}
