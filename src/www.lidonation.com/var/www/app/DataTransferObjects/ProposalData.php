<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
final class ProposalData extends Data
{
    public function __construct(
        public ?int $id,

        public ?string $title,

        public string $link,

        #[TypeScriptOptional]
        public ?string $status
    ) {
    }
}
