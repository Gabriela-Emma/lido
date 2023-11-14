<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\Transformers\ShortcodeTransformer;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
final class QuizQuestionData extends Data
{
    public function __construct(
        public ?int $id,

        public ?string $title,

        #[TypeScriptOptional]
        #[WithTransformer(ShortcodeTransformer::class)]
        public ?string $content,

        #[TypeScriptOptional]
        public ?string $type,

        #[TypeScriptOptional]
        public ?string $status,

        #[DataCollectionOf(QuizQuestionAnswerData::class)]
        public ?DataCollection $answers
    ) {
    }
}
