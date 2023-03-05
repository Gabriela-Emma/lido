<?php

namespace App\Nova\Actions;

use App\Models\Reward;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class IssueAdditionalRewards extends Action implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Issue Additional Rewards';

    /**
     * Perform the action on the given models.
     *
     * @return string[]|void
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        if (! isset($fields->asset)) {
            return Action::danger('Epoch Field Required.');
        }

        if (! isset($fields->amount)) {
            return Action::danger('Epoch Field Required.');
        }

        $models->each(function (Reward $r) use ($fields) {
            $reward = new Reward;
            $reward->user_id = $r->user_id;
            $reward->memo = $r->memo;
            $reward->asset = $fields->asset;
            $reward->withdrawal_id = $r->withdrawal_id;
            $reward->model_id = $r->model->id;
            $reward->model_type = $r->model::class;
            $reward->asset_type = 'ft';
            $reward->amount = $fields->amount;
            $reward->status = 'issued';
            $reward->stake_address = $r->user->wallet_stake_address;
            $reward->save();
        });
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Text::make('Type'),
            Text::make('asset'),
            Number::make('Amount'),
        ];
    }
}
