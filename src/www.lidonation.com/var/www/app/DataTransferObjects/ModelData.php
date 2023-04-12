<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ModelData extends Data
{
    public function __construct(
        public ?int $id,
        public ?string $slug,
        public string $title,
        public string $content,
        #[TypeScriptOptional]
        public ?string $link
    ) {}
}
