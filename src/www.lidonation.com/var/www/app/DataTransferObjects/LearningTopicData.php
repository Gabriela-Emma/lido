<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class LearningTopicData extends Data
{
    public function __construct(
        public int $id,
        public string $title,
        public ?string $content,
        public ?int $length,
        public string $link,
        public ?int $lessons_count,
        #[DataCollectionOf(LearningLessonData::class)]
        public ?DataCollection $lessons,
    ) {
    }
}
