<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use App\DataTransferObjects\AssetDetailsData;
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
      public ?AssetDetailsData $asset_details = null,
      public ?string $memo

    ) {}
}


