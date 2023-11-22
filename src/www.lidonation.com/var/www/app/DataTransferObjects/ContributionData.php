<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ContributionData extends Data
{
    public function __construct(
        //
        public int $id,

        public string $title,

        public ?string $content,

        public string $model_type,

        public ?int $model_id,

        public ?int $user_id,

        public ?string $status,

        public ?string $timestamp,

        public ?string $softdelete,

    ) {
    }
}
