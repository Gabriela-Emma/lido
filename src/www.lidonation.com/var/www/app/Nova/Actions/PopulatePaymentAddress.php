<?php

namespace App\Nova\Actions;

use App\Jobs\PopulatePaymentAddressJob;
use App\Models\Interfaces\HasAuthor;
use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;

class PopulatePaymentAddress extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Populate Payment Address';

    /**
     * Indicates if this action is only available on the resource detail view.
     *
     * @var bool
     */
    public $onlyOnDetail = false;

    /**
     * The text to be used for the action's confirm button.
     *
     * @var string
     */
    public $confirmButtonText = 'Populate';

    protected $message = '';

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     * @return void
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (HasAuthor|User $model) use ($fields) {
            try {
                $model = ($model instanceof HasAuthor) ? $model->user : $model;

                if ($fields->skip && isset($model->wallet_address)) {
                    $this->message = "Payment address already exist for id {$model->id}, no update!";
                } else {
                    PopulatePaymentAddressJob::dispatch($model);
                    $this->message = 'Populating payment address successful.';
                }
            } catch (Exception $e) {
                $this->markAsFailed($model, $e);
            }
        });

        return Action::message($this->message);
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
            Boolean::make('skip'),
        ];
    }
}
