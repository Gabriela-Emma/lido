<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;

class CatalystCommunityData extends Data
{
    public function __construct(
        public int $id,

        public string $title,

        public ?string $content,

        public ?int $user_id,

        public ?string $status,

        public ?string $timestamp,

        public ?string $softdelete,

    ) {
    }
}
