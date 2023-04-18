<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\WithCast;
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

      public ?bool $correct,

      #[WithCast(QuizQuestionData::class)]
      public ?QuizQuestionData $question,

      #[WithCast(QuizData::class)]
      public ?QuizData $quiz,

      #[WithCast(QuizQuestionAnswerData::class)]
      public ?QuizQuestionAnswerData $questionAnswer,

      #[TypeScriptOptional]
      public ?string $stake_address,
  ) {}
}

