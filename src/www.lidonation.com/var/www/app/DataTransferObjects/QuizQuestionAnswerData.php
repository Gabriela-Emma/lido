<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\Transformers\ShortcodeTransformer;
use Livewire\Wireable;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class QuizQuestionAnswerData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $id,
        public ?string $title,

        #[TypeScriptOptional]
        #[WithTransformer(ShortcodeTransformer::class)]
        public ?string $content,

        #[TypeScriptOptional]
        public ?string $type,

        #[TypeScriptOptional]
        public ?string $hint,

        #[TypeScriptOptional]
        public ?string $status,

        #[TypeScriptOptional]
        public ?string $correctness
    ) {}
}
