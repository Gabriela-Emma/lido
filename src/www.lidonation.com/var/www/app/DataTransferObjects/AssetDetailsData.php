<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
final class AssetDetailsData extends Data
{
    public function __construct(
        public ?string $asset_name,
        public ?int $divisibility,
        public ?AssetMetaData $metadata = null,
    ) {
    }
}
