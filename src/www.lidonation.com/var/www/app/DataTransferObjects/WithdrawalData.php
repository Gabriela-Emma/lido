<?php

namespace App\DataTransferObjects;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class WithdrawalData extends Data
{
    public function __construct(
        public ?int $id,

        public ?string $status,

        public ?int $rewards_count,

        #[TypeScriptOptional]
        #[WithCast(DateTimeInterfaceCast::class)]
        #[WithTransformer(DateTimeInterfaceTransformer::class)]
        public ?DateTime $created_at,

        #[TypeScriptOptional]
        #[DataCollectionOf(TxData::class)]
        public ?DataCollection $txs,

        #[TypeScriptOptional]
        public ?string $withdrawal_tx,

        #[TypeScriptOptional]
        public ?Collection $amounts,

        #[TypeScriptOptional]
        #[DataCollectionOf(RewardData::class)]
        public ?DataCollection $rewards,
    ) {
    }
}
