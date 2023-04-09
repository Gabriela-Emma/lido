<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class LearningLessonData extends Data
{
    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        #[TypeScriptOptional]
        public ?int $length,
        #[TypeScriptOptional]
        public ?string $link,
        #[TypeScriptOptional]
        public ?LearningTopicData $topic
    ) {}
}
