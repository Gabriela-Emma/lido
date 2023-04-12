<?php

namespace App\DataTransferObjects;

use App\Models\LearningLesson;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;
use Webwizo\Shortcodes\Facades\Shortcode;

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
