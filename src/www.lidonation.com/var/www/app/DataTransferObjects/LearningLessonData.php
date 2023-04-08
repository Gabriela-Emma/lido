<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;

class LearningLessonData extends Data
{
    public function __construct(
        public string $title,
        public string $content,
        public ?int $length,
        public ?string $link,
        public ?LearningTopicData $topic
    ) {}
}
