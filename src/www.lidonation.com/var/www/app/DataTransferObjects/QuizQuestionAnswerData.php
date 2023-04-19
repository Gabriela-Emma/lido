<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\Transformers\ShortcodeTransformer;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class QuizQuestionAnswerData extends Data
{
    public function __construct(
        public ?int $id,

        public ?string $title,

        #[TypeScriptOptional]
        #[WithTransformer(ShortcodeTransformer::class)]
        public ?string $content,

        #[TypeScriptOptional]
        public ?bool $correct,

        #[TypeScriptOptional]
        public ?string $correctness,

        #[TypeScriptOptional]
        public ?string $hint,

        #[TypeScriptOptional]
        public ?string $status,

        #[TypeScriptOptional]
        public ?string $type,

        #[TypeScriptOptional]
        public ?QuizQuestionData $question,
    ) {}
}
