<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;

#[TypeScript]
class RewardData extends Data
{
    public function __construct(
      public ?int $id,
      public ?string $asset,
      public ?int $amount,
      #[TypeScriptOptional]
      public ?string $asset_type,
      public ?string $status,
      public ?AssetDetailsData $asset_details,
      public ?string $memo

    ) {}
}

#[TypeScript]
class AssetDetailsData extends Data
{
    public function __construct(
        public string $asset_name,
        public int $divisibility,
        public ?AssetMetaData $metadata = null,
    ) {}
}

#[TypeScript]
class AssetMetaData extends Data
{
    public function __construct(
        public ?string $logo = null,
        public ?string $ticker = null,
    ) {}
}
