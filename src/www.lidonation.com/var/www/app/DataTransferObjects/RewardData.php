<?php

namespace App\DataTransferObjects;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class RewardData extends Data
{
    public function __construct(
        public ?int $id,

        public ?string $asset,

        public ?int $amount,

        #[TypeScriptOptional]
        public ?string $asset_type,

        #[TypeScriptOptional]
        #[WithCast(DateTimeInterfaceCast::class, type: CarbonImmutable::class)]
        public ?CarbonImmutable $created_at,

        public ?string $status,

        #[TypeScriptOptional]
        public ?AssetDetailsData $asset_details,

        public ?string $memo
    ) {
    }
}
