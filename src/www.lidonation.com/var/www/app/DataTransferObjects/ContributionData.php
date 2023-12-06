<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
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
