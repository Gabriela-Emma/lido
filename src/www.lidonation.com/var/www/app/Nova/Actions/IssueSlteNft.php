<?php

namespace App\Nova\Actions;

use App\Jobs\IssueNftsJob;
use App\Models\LearningTopic;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class IssueSlteNft extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            if ($model instanceof User) {
                $topicIds = LearningTopic::pluck('id');
                $userNftIds = $model->nfts()->where('model_type', LearningTopic::class)->pluck('model_id');
                $unIssuedTopicNftIds = $topicIds->diff($userNftIds)->all();
                foreach ($unIssuedTopicNftIds as $topicId) {
                    $learningTopic = LearningTopic::find($topicId);
                    $topicCompleted = $model->completedTopics->contains($topicId);
                    $learningLesson = $learningTopic->learningLessons?->first();

                    if ($topicCompleted) {
                        IssueNftsJob::dispatch($learningTopic, $learningLesson, $model);
                    } else {
                        Action::danger('Failed to issue NFT for User ');

                        continue;
                    }
                }
            } else if ($model instanceof LearningTopic) {
            }
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
