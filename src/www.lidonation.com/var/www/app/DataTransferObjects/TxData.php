<?php

namespace App\DataTransferObjects;

use DateTime;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TxData extends Data
{
    public function __construct(
        public ?int $id,

        public ?string $policy,

        public ?string $hash,

        public ?string $address,

        public ?string $status,

        public ?string $quantity,

        #[TypeScriptOptional]
        #[WithCast(DateTimeInterfaceCast::class)]
        #[WithTransformer(DateTimeInterfaceTransformer::class)]
        public ?DateTime $created_at
    ) {}
}
