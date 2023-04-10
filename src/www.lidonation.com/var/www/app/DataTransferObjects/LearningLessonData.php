<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class LearningLessonData extends Data
{
    public function __construct(
        public string $hash,
        public string $title,
        public string $content,
        public ?int $length,
        public ?int $order,
        public null | bool | Optional $completed,
        #[TypeScriptOptional]
        public ?string $link,
        #[TypeScriptOptional]
        public ?LearningTopicData $topic
    ) {}
}
