<?php

namespace App\Nova\Actions;

use App\Models\Nft;
use App\Models\User;
use App\Jobs\IssueNftsJob;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use App\Models\LearningLesson;
use App\Models\LearningTopic;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Http\Requests\NovaRequest;

class IssueSlteNft extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
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
                        IssueNftsJob::dispatch($learningTopic, $learningLesson);
                    } else {
                        Action::danger('Failed to issue NFT for User ');

                        continue;
                    }
                }
            }

            if ($model instanceof LearningTopic) {
            }
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
