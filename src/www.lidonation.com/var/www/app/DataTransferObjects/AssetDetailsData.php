<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use App\DataTransferObjects\AssetMetaData;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AssetDetailsData extends Data
{
    public function __construct(
        public ?string $asset_name,
        public ?int $divisibility,
        public ?AssetMetaData $metadata = null,
    ) {}
}