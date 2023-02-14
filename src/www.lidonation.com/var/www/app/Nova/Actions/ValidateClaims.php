<?php

namespace App\Nova\Actions;

use App\Models\Meta;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Http\Requests\NovaRequest;

class ValidateClaims extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection $models
     * @return string[]
     */
    public function handle(ActionFields $fields, Collection $models): array
    {
        $code = $fields->code;
        foreach ($models as $model) {
            $id = $model->id;
            $meta = $model->metas()->where('key', 'ideascale_verification_code')->where('content', $code)->first();
            // user making the claim
            $regularUser = User::whereHas('metas', function ($query) use ($code) {
                $query->where('key', 'ideascale_verification_code')->where('content', $code);
            })->first();

            // getting related data
            $data=Meta::where('key','claim_data')->where('model_id', $id)->first();
            $claim_data=collect(json_decode($data->content));
            $dataUpdate= [
                'claimed_by' => $regularUser->id,
                'email' => $claim_data['email'],
                'bio' => $claim_data['bio'],
                'ideascale' => $claim_data['ideascale'],
                'twitter' => $claim_data['twitter'],
                'discord' => $claim_data['discord'],
                'linkedin' => $claim_data['linkedin'],
            ];
            // Filter out any null values in the $dataUpdate array
            $userData = array_filter($dataUpdate, function ($value) {
                return $value !== null && $value !== '';
            });

            // validating claims
            if ($meta && $regularUser) {
                $regularUser->assignRole((string) RoleEnum::proposer());
                $model->fill($userData);
                $regularUser->catalyst_users()->save($model);
                $regularUser->name = $claim_data['name'];
                $regularUser->save();
                
                event(new Registered($model->user));

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
