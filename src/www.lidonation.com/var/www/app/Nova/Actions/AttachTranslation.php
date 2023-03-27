<?php

namespace App\Nova\Actions;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class AttachTranslation extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Attach Translation';

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
    public $confirmButtonText = 'Attach';

    protected $message = '';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function ($model) {
            try {
                if ($model->status == 'published') {
                    $obj = App::make($model->source_type);
                    $obj->where('id', $model->source_id)
                        ->update(["content->{$model->lang}" => $model->content]);

                    $this->message = Action::message('Translation attached');
                } else {
                    $this->message = Action::danger('Cannot attach unpublished translation.');
                }
            } catch (Exception $e) {
                $this->markAsFailed($model, $e);
            }
        });

        return $this->message;
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
