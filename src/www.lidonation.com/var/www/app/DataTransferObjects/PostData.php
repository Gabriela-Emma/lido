<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class PostData extends Data
{
    public function __construct(
        public ?string $title,

        public ?int $id,

        public ?string $author_name,

        public ?string $author_gravatar,

        public ?string $link,

        public ?string $published_at,

        public ?string $read_time,

    ) {
    }
}
