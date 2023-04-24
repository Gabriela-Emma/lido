<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class LearningModuleData extends Data
{
    public function __construct(
        public int $id,

        public string $title,

        #[TypeScriptOptional]
        public ?string $content,

        public string $link,

        public ?int $length,

        public ?int $lessons_count,

        public ?int $topics_count,

        public ?array $model,

        public ?array $metadata,

        #[DataCollectionOf(LearningTopicData::class)]
        public ?DataCollection $topics
    ) {
    }
}
