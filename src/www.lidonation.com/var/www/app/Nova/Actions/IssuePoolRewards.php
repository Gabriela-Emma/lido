<?php

namespace App\Nova\Actions;

use App\Services\CardanoBlockfrostService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class IssuePoolRewards extends Action implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Issue Pool Rewards';

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     * @return string[]|void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        if (! isset($fields->epoch)) {
            return Action::danger('Epoch Field Required.');
        }

        $pool = config('cardano.pool.hash');
        $page = 1;

        do {
            $delegators = app(CardanoBlockfrostService::class)
                ->get("/pools/{$pool}/delegators", ['count' => 30, 'page' => $page])
                ->collect();

            $delegators->each(fn ($delegator) => \App\Jobs\IssuePoolRewards::dispatch($delegator['address'], $fields->epoch, $models->first()));
            $page++;
            sleep(10);
        } while ($delegators->isNotEmpty());
    }

    /**
     * Get the fields available on the action.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Number::make('epoch'),
        ];
    }
}
