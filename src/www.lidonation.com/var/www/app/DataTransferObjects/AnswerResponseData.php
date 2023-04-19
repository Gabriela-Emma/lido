<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AnswerResponseData extends Data
{
  use WireableData;

  public function __construct(
      public int $id,

      #[MapOutputName('userId')]
      public ?int $user_idd,

      #[MapOutputName('questionAnswerId')]
      public ?int $question_answer_id,

      #[TypeScriptOptional]
      #[MapOutputName('createdAt')]
      #[WithCast(DateTimeInterfaceCast::class, timeZone: 'Africa/Nairobi')]
      public $created_at,

      public ?bool $correct,

      public ?QuizQuestionData $question,

      public ?QuizData $quiz,

      public ?QuizQuestionAnswerData $questionAnswer,

      #[TypeScriptOptional]
      public ?string $stake_address,
  ) {}
}

