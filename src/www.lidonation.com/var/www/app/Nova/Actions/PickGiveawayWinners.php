<?php

namespace App\Nova\Actions;

use App\Models\Setting;
use App\Models\TwitterEvent;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class PickGiveawayWinners extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Run Giveaway';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function ($model) {
            try {
                $event = TwitterEvent::first();
                $twitter_access_token = (Setting::where('key', 'twitter_lido_access_token')->first())?->value;

                if ($twitter_access_token == null) {
                    return;
                }

                $retweeters = collect([]);
                $retweetsResponse = Http::withToken($twitter_access_token['token'])
                    ->get("https://api.twitter.com/2/tweets/{$event->event_post}/retweeted_by", [
                        'tweet.fields' => 'created_at,referenced_tweets',
                        'user.fields' => 'id,name,profile_image_url',
                        //                    'expansions' => 'pinned_tweet_id',

                    ]);

                // add retweeters
                if ($retweetsResponse->successful()) {
                    $retweeters = collect($retweetsResponse->object()?->data);
                }

                $response = Http::withToken($twitter_access_token['token'])
                    ->get("https://api.twitter.com/2/spaces/{$event->event_id}", [
                        'space.fields' => 'id,host_ids,creator_id,created_at,started_at,ended_at,state,title,updated_at,scheduled_start,participant_count,subscriber_count,speaker_ids,invited_user_ids',
                        'expansions' => 'host_ids,invited_user_ids',
                        'user.fields' => 'id,name,profile_image_url',
                    ]);

                $data = $response->object()?->data;
                if ($data) {
                    // add pop multipliers
                    $pops = $event->attendances()->get('twitter_user_id')->pluck('twitter_user_id')->toArray();
                    $tickets = collect($data?->invited_user_ids);
                    $tickets = $tickets->merge($data->speaker_ids)->merge($pops)->merge($pops)->merge($retweeters->pluck('id')->values());

                    $winners = $tickets->shuffle()->random(60);
                    $twitterUserValues = collect($response->object()?->includes?->users);

                    // select winners
                    $winners = $twitterUserValues->whereIn('id', $winners);
                    $event->saveMeta('giveaways', $winners->toJson(), $event, false);
                }
            } catch (Exception $e) {
                Log::error('action failed', [$e->getMessage()]);
                $this->markAsFailed($model, $e);
            }
        });
    }
}
