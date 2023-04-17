<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use App\DataTransferObjects\AssetDetailsData;
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
      #[DataCollectionOf(AssetDetailsData::class)]
      public ?DataCollection $asset_details = null,
      public ?string $memo

    ) {}
}


