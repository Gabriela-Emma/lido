<?php

namespace App\Nova\Actions;

use App\Models\Interfaces\IHasMetaData;
use App\Models\Model;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class EditMetaData extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Indicates if this action is only available on the resource detail view.
     *
     * @var bool
     */
    public $onlyOnDetail = true;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Edit Meta Data';

    public function __construct(public string $modelType)
    {
    }

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (IHasMetaData $model) use ($fields) {
            try {
                foreach ($fields->toArray() as $field => $value) {
                    $model->saveMeta($field, $value, $model);
                }
            } catch (\Exception $e) {
                if ($model instanceof Model) {
                    $this->markAsFailed($model, $e);
                }
            }

//            try {
//                $model->saveMeta($meta->key, $fields->{$meta->key}, $model);
//            } catch (\Exception $e) {
//                if($model instanceof Model) {
//                    $this->markAsFailed($model, $e);
//                }
//            }
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $modelObj = $this->modelType::find(request()->resourceId ?? Request::get('resources'));

        if (! isset($modelObj)) {
            return [];
        }

        return $modelObj->metas->map(function ($meta) {
            return Text::make(Str::title($meta->key), $meta->key)
                ->default($meta->content);
        })->all();
    }
}
