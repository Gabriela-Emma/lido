<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use App\DataTransferObjects\AssetMetaData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AssetDetailsData extends Data
{
    public function __construct(
        public string $asset_name,
        public int $divisibility,
        #[DataCollectionOf(AssetMetaData::class)]
        public ?DataCollection $metadata = null,
    ) {}
}