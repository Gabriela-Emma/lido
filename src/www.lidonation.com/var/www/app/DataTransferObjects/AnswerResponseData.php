<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AnswerResponseData extends Data
{
  use WireableData;

  public function __construct(
      public ?int $id,
      
      public ?int $user_id,
      
      public ?int $question_id,
      
      public ?int $quiz_id,

      public ?int $question_answer_id,

      #[TypeScriptOptional]
      public ?string $stake_address,
  ) {}
}

