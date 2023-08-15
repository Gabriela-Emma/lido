<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ProposalRatingData extends Data
{

    public function __construct(
        public ?int $id,

        public string $rationale,

        public string $rating,

        public $meta_data,

        public ProposalData $proposal,

        #[TypeScriptOptional]
        public ?string $status
    ) {
    }
}
