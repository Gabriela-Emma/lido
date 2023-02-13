<?php

namespace App\Nova\Actions;

use App\Models\User;
use App\Enums\RoleEnum;
use App\Models\CatalystUser;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Http\Requests\NovaRequest;

class ValidateClaims extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $code = $fields->code;
        foreach ($models as $model) {
            $id = $model->id;
            $meta = $model->metas()->where('key', 'ideascale_verification_code')->where('content', $code)->first();
            $regularUser = User::whereHas('metas', function ($query) use ($code) {
                $query->where('key', 'ideascale_verification_code')->where('content', $code);
            })->first();

            if ($meta && $regularUser) {
                $regularUser->assignRole((string) RoleEnum::proposer());
                $model->claimed_by=$regularUser->id;
                $regularUser->catalyst_users()->save($model);
                


                return Action::message('Validation performed successfully!');
            }
        }
    
        return Action::danger('failed');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make('code')
                ->required()
                ->rules('max:5')
        ];
    }
}
