<?php

namespace App\Jobs;

use App\Models\Nft;
use App\Models\Reward;
use App\Models\LearningTopic;
use Illuminate\Bus\Queueable;
use App\Models\LearningLesson;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class IssueNftsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public LearningTopic $topic,
        public LearningLesson $learningLesson,
        public User $user
        ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $nftTemplate = $this->topic->nftTemplate;

        if (!$nftTemplate instanceof Nft) {
            return null;
        }

        $userNft = new Nft;
        $originalAttributes = $nftTemplate->getAttributes();
        unset($originalAttributes['id'], $originalAttributes['txs_count']);
        $metadata = json_decode($originalAttributes['metadata'], true);
        unset($metadata['topic_id']);
        $originalAttributes['metadata'] = json_encode($metadata);
        $userNft->setRawAttributes($originalAttributes);
        $userNft->user_id = Auth::id();
        $userNft->model_type = LearningTopic::class;
        $userNft->model_id = $this->topic->id;
        $userNft->name = $nftTemplate->name . $this->topic->nfts->count();
        $userNft->save();

        // issue nft reward
        $reward = new Reward;
        $reward->user_id = Auth::id();
        $reward->model_id = $this->learningLesson->id;
        $reward->model_type = LearningLesson::class;
        $reward->asset = $userNft->name;
        $reward->asset_type = $nftTemplate->policy;
        $reward->amount = 1;
        $reward->status = 'issued';
        $reward->stake_address = $this->user->wallet_stake_address;
        $reward->setTranslation('memo', 'en', $this->learningLesson->title);
        $reward->save();
    }
}
