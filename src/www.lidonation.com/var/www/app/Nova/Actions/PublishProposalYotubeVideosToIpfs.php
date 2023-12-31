<?php

namespace App\Nova\Actions;

use App\Jobs\PublishProposalYotubeVideosToIpfsJob;
use App\Models\CatalystExplorer\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class PublishProposalYotubeVideosToIpfs extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Publish Video To Ipfs';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (Proposal $p) {
            try {
                PublishProposalYotubeVideosToIpfsJob::dispatch($p);
            } catch (\Exception $e) {
                $this->markAsFailed($p, $e);
            }
        });
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
