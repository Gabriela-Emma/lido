<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
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
        #[MapOutputName('retryAt')]
//        #[WithCast(DateTimeInterfaceCast::class, type: CarbonImmutable::class)]
        public $retry_at,

        #[TypeScriptOptional]
        public ?string $link,

        #[TypeScriptOptional]
        public ?QuizData $quiz,

        #[DataCollectionOf(QuizData::class)]
        public ?DataCollection $quizzes,

        #[TypeScriptOptional]
        public ?ModelData $model,

        #[TypeScriptOptional]
        public ?LearningTopicData $topic
    ) {}

//    public static function fromModel(LearningLesson $learningLesson): LearningLessonData
//    {
//        if ($learningLesson->model?->content) {
//            $learningLesson->model->content = Shortcode::compile($learningLesson?->model?->content);
//        }
//        return new self(...$learningLesson->get(['hash', 'title', 'content', 'length', 'model',]));
//    }
}
