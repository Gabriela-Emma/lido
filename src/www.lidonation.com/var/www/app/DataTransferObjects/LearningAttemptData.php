<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
final class LearningAttemptData extends Data
{
    public function __construct(
        #[TypeScriptOptional]
        #[MapOutputName('retryAt')]
        public mixed $retry_at,

        #[TypeScriptOptional]
        #[MapOutputName('nextLessonAt')]
        public mixed $next_lesson_at,

        #[TypeScriptOptional]
        public ?AnswerResponseData $response,

        #[TypeScriptOptional]
        public ?QuizData $quiz,

        #[TypeScriptOptional]
        public ?LearningModuleData $module,

        #[TypeScriptOptional]
        public ?LearningTopicData $topic,

        #[TypeScriptOptional]
        public ?LearningLessonData $lesson,
    ) {
    }
}
