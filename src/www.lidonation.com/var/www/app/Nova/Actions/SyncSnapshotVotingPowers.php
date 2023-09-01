<?php

namespace App\Nova\Actions;

use App\Jobs\SyncCatalystVotingPowersJob;
use App\Models\CatalystRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class SyncSnapshotVotingPowers extends Action implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Sync Snapshot Voting Powers';

     /**
     * The text to be used for the action's confirm button.
     *
     * @var string
     */
    public $confirmButtonText = 'Sync';

    /**
     * Perform the action on the given models.
     */
    public function handle(ActionFields $fields, Collection $models): mixed
    {
        $models->each(function ($snapshot) {
            try {
                $registeredStakePub = CatalystRegistration::where('created_at', '<', $snapshot->snapshot_at)
                    ->pluck('stake_pub')
                    ->unique();

                foreach($registeredStakePub as $stakeAddress) {
                    dispatch(new SyncCatalystVotingPowersJob(
                        $snapshot,
                        $stakeAddress
                    ));
                }
            } catch (\Exception $e) {
                $this->markAsFailed($m, $e);
            }
        });
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(NovaRequest $request): array
    {
        return [];
    }
}
