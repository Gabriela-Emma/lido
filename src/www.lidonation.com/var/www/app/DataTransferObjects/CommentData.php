<?php

namespace App\DataTransferObjects;

use Livewire\Wireable;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CommentData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $id,

        public ?string $title,

        public string $text,

        #[TypeScriptOptional]
        public ?string $status,

        #[TypeScriptOptional]
        #[MapOutputName('createdAt')]
        public mixed $created_at
    ) {
    }
}
