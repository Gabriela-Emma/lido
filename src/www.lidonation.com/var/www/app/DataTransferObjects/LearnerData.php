<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use App\DataTransferObjects\LearningLessonData;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;

#[TypeScript]
class LearnerData extends Data
{
    public function __construct(
      public ?string $name,

      #[TypeScriptOptional]
      public ?string $wallet_address,

      public ?string $email,

      #[TypeScriptOptional]
      public ?string $stake_address, 

      #[TypeScriptOptional]
      #[MapOutputName('nextLessonAt')]
      public mixed $next_lesson_at,

      #[TypeScriptOptional]
      #[MapOutputName('nextLesson')]
      public mixed $next_lesson,

      #[TypeScriptOptional]
      public mixed $retry_at,


    ) {}
}
