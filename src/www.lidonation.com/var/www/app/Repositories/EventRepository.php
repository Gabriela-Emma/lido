<?php

namespace App\Repositories;

use App\Models\Event;
use JetBrains\PhpStorm\Pure;

class EventRepository extends Repository
{
    // Constructor to bind model to repo
    #[Pure]
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

    public function upcoming()
    {
        return $this->model->upcoming()->get();
    }
}
