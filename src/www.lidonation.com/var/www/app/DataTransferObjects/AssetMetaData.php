<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AssetMetaData extends Data
{
    public function __construct(
        public ?string $logo = null,
        public ?string $ticker = null,
    ) {}
}