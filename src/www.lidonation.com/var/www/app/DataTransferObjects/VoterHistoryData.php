<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class VoterHistoryData extends Data
{
    public function __construct(
        public ?int $time,

        public ?string $proposal,

        public ?string $fragment_id,

        public ?string $caster,

        public ?string $raw_fragment,

        public ?int $choice,

    ) {
    }
}
