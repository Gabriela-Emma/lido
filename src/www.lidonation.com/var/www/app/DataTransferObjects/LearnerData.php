<?php

namespace App\DataTransferObjects;

use App\Models\LearningTopic;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class LearnerData extends Data
{
    public function __construct(
        public ?string $name,

        public ?string $active_pool_id,

        #[TypeScriptOptional]
        public ?string $wallet_address,

        public ?string $email,

        #[TypeScriptOptional]
        public ?string $wallet_stake_address,

        #[TypeScriptOptional]
        #[MapOutputName('nextLessonAt')]
        public ?string $next_lesson_at,

        #[TypeScriptOptional]
        #[MapOutputName('nextLesson')]
        public ?LearningLessonData $next_lesson,

        #[TypeScriptOptional]
        #[MapOutputName('totalRewardSum')]
        public ?int $total_reward_sum,

        #[TypeScriptOptional]
        #[MapOutputName('availableRewards')]
        #[DataCollectionOf(RewardData::class)]
        public ?DataCollection $available_rewards,

        #[DataCollectionOf(LearningTopicData::class)]
        public ?DataCollection $completed_topics
    ) {
    }
}
