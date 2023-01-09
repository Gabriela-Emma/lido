<?php

namespace App\Nova\Actions;

use App\Models\Setting;
use App\Models\TwitterEvent;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class SyncWithTwitterSpaceApi extends Action
{
//    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function ($model) {
            try {
                $event = TwitterEvent::first();
                $twitter_access_token = (Setting::where('key', 'twitter_lido_access_token')->first())?->value;
                $response = Http::withToken($twitter_access_token['token'])
                    ->get("https://api.twitter.com/2/spaces/{$event->event_id}", [
                        'space.fields' => 'id,host_ids,creator_id,created_at,started_at,ended_at,state,title,updated_at,scheduled_start,participant_count,subscriber_count,speaker_ids,invited_user_ids',
                    ]);
                $data = $response->object()?->data;

                $model->title = $data?->title;
                $model->status = $data?->state;
                $model->creator_id = $data?->creator_id;
                $model->scheduled_at = $data?->scheduled_start;
                $model->participant_count = $data?->participant_count;
                $model->subscriber_count = $data?->subscriber_count;
                $model->started_at = Carbon::parse($data?->started_at);
                $model->created_at = Carbon::parse($data?->created_at);
                $model->ended_at = Carbon::parse($data?->ended_at ?? null);
                $model->save();
            } catch (Exception $e) {
                Log::error('action failed', [$e->getMessage()]);
                $this->markAsFailed($model, $e);
            }
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
