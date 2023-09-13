<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TaxonomyData extends Data
{
    public function __construct(
        public int $id,

        public string $title,

        public string $slug,

        // #[MapOutputName('current_fund_proposal')]
        public ?int $current_fund_proposals,

    ) {
    }
}
