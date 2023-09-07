<?php

namespace App\DataTransferObjects;


use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TaxonomyData extends Data
{
    public function __construct(
        public ?int $id,

        public ?string $title,

        public ?string $proposals_count,

    ) {
    }
}
