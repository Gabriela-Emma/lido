<?php

namespace App\Nova\Actions;

use App\Enums\RoleEnum;
use App\Events\CatalystProfileVerified;
use App\Models\Meta;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class ValidateClaims extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return string[]
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $code = $fields->code;
        foreach ($models as $model) {
            $id = $model->id;
            $meta = $model->metas()->where('key', 'ideascale_verification_code')->where('content', $code)->first();
            // user making the claim
            $regularUser = User::whereHas('metas', fn ($query) => $query->where([
                'key' => 'ideascale_verification_code',
                'content' => $code,
            ])
            )->first();

            if (! $regularUser instanceof User) {
                return Action::danger('Could not find user');
            }

            // getting related data
            $data = Meta::where('key', 'claim_data')->where('model_id', $id)->first();
            $claim_data = collect(json_decode($data->content));
            $dataUpdate = [
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

                event(new CatalystProfileVerified($model));

                return Action::message('Validation performed successfully!');
            }
        }

        return Action::danger('failed');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make('code')
                ->required()
                ->rules('max:5'),
        ];
    }
}
