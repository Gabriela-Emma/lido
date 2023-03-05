<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class SetProposalStatus extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Set Status';

    /**
     * Perform the action on the given models.
     */
    public function handle(ActionFields $fields, Collection $models): mixed
    {
        $models->each(function ($m) use ($fields) {
            try {
                $m->status = $fields->status;
                $m->save();
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
        return [
            Select::make(__('Status'), 'status')->options([
                'pending' => 'Pending',
                'unfunded' => 'Unfunded',
                'funded' => 'Funded',
                'complete' => 'Complete',
                'retired' => 'Retired',
                'startup' => 'Startup',
                'growth' => 'Growth',
                'expansion' => 'Expansion',
                'matured' => 'Matured',
            ]),
        ];
    }
}
