<?php

namespace App\DataTransferObjects;

use Livewire\Wireable;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class QuizData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public ?int $id,

        public string $title,

        public string $content,

        #[TypeScriptOptional]
        public ?string $status,

        #[DataCollectionOf(CommentData::class)]
        public ?DataCollection $questions
    ) {
    }
}
