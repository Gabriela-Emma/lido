<?php

namespace App\DataTransferObjects;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;

#[TypeScript]
class UserData extends Data
{
    public function __construct(
      public ?string $name,

      // #[TypeScriptOptional]
      public ?string $wallet_address,

      public ?string $email,

      // #[TypeScriptOptional]
      public ?string $stake_address, 

      // #[TypeScriptOptional]
      public ?string $next_lesson_at,

      // #[TypeScriptOptional]
      public ?LearningLessonData $nextLesson,

      // #[TypeScriptOptional]
      public ?string $retry_at,


    ) {}
}
