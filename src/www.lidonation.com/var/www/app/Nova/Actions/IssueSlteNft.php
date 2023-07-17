<?php

namespace App\Nova\Actions;

use App\Models\Nft;
use App\Jobs\IssueNftsJob;
use Illuminate\Bus\Queueable;
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
        $models->each(function ($model) {
            $learningTopic = $model->topic;
            $users = Auth::user();

            foreach ($users as $user) {
                $topicNft = $user->nfts()->where([
                    'model_id' => $learningTopic->id,
                    'model_type' => LearningTopic::class
                ])->first();

                if (!$topicNft instanceof Nft) {
                    IssueNftsJob::dispatchSync($learningTopic, $user);
                }
            }
        });
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
