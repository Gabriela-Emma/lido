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

class GenarateVoterHistory extends Action
{
    use InteractsWithQueue, Queueable;


    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Genarate Voter History';


    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
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
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
