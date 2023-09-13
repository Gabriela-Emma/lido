<?php

namespace App\Repositories;

use App\Models\Cardano\Epoch;
use JetBrains\PhpStorm\Pure;

class EpochRepository extends DbSyncRepository
{
    // Constructor to bind model to repo
    #[Pure]
    public function __construct(Epoch $model)
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

    public function current(): ?Epoch
    {
        $current = null;
        try {
            $current = $this->model
                ->orderBy('start_time', 'desc')->first();
        } catch (\Exception $e) {
            $this->handleException($e);
        }

        return $current;
    }
}
