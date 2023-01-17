<?php

namespace App\Nova\Actions;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class DispersePoolRewards extends Action implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Disperse Pool Rewards';

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(ActionFields $fields, Collection $models): void
    {
        // group rewards by user
        $models->groupBy('user_id')->each(function ($group) {
            // foreach group user rewards create a withdrawal instance
            $user = $group->first()->user;
            $withdrawal = new Withdrawal;
            $withdrawal->wallet_address = $user->wallet_address;
            $withdrawal->status = 'validated';
            $withdrawal->user_id = $user?->getAuthIdentifier();
            $withdrawal->save();

            // add rewards to withdrawal
            $group->each(function ($reward) use ($withdrawal) {
                $reward->status = 'processed';
                $reward->withdrawal_id = $withdrawal->id;
                $reward->save();
            });
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [];
    }
}
