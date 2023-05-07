<?php

namespace App\DataTransferObjects;


use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;

#[TypeScript]
class PromoData extends Data
{
    public function __construct(
      public ?string $title,

      public ?string $uri,

      #[MapOutputName('feature_url')]
      public ?string $feature_url,

      public ?string $content,

    ) {
    }
}
