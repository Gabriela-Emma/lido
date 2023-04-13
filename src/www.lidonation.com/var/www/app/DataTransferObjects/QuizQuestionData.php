<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\Transformers\ShortcodeTransformer;
use Livewire\Wireable;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;
use Webwizo\Shortcodes\Facades\Shortcode;

#[TypeScript]
class QuizQuestionData extends Data implements Wireable
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
        public ?string $status,

        #[DataCollectionOf(QuizQuestionAnswerData::class)]
        public ?DataCollection $answers
    ) {}
}
