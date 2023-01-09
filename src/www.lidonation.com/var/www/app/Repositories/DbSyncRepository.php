<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

class DbSyncRepository extends Repository
{
    // Constructor to bind model to repo
    #[Pure]
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

       protected function handleException(\Exception $e)
       {
           report($e);
       }
}
