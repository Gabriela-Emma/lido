<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class PostSearchResultData extends Data
{
    public function __construct(
        public ?string $type,

        #[DataCollectionOf(PostData::class)]
        public ?DataCollection $items

    ) {
    }
}
