<?php

namespace App\Nova\Actions;

use Exception;
use App\Jobs\GetVoterHistory;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Http\Requests\NovaRequest;

class GenerateVoterHistory extends Action
{
    use InteractsWithQueue, Queueable;


    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Generate Voter History';


    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection $models
     * @return void
     */
    public function handle(ActionFields $fields, Collection $models): void
    {
        $models->each(
            function ($model) {
                try {
                    GetVoterHistory::dispatch($model);
                } catch (Exception $e) {
                    $this->markAsFailed($model, $e);
                }
            }
        );
    }

    /**
     * Get the fields available on the action.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [];
    }
}
