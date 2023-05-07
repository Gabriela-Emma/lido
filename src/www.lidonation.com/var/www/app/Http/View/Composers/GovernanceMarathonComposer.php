<?php

namespace App\Http\View\Composers;

use App\Models\Setting;
use App\Models\TwitterEvent;
use Atymic\Twitter\Facade\Twitter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;
use Illuminate\View\View;

class GovernanceMarathonComposer
{
    public function compose(View $view): void
    {
        $space = null;
        $twitterUsers = [];
        $twitter_access_token = Setting::where('key', 'twitter_lido_access_token')->first()?->value;
        $event = TwitterEvent::first();
        if ($twitter_access_token) {
            $twitter_access_token = new Fluent($twitter_access_token);
            $response = Http::withToken($twitter_access_token->token)
                ->get("https://api.twitter.com/2/spaces/{$event->event_id}", [
                    'space.fields' => 'id,host_ids,creator_id,created_at,started_at,ended_at,state,title,updated_at,scheduled_start,participant_count,subscriber_count,speaker_ids,invited_user_ids',
                    'expansions' => 'host_ids,speaker_ids',
                    'user.fields' => 'id,name,profile_image_url',
                ]);

            if ($response->successful()) {
                $space = $response->object()?->data;
                $twitterUserKeys = collect($response->object()?->includes?->users)->map(fn ($u) => $u->id);
                $twitterUserValues = collect($response->object()?->includes?->users);
                $twitterUsers = $twitterUserKeys->combine($twitterUserValues);
            }
            $response = Http::withToken($twitter_access_token->token)
                ->get("https://api.twitter.com/2/tweets/{$event->event_post}/retweeted_by", [
                    'tweet.fields' => 'created_at,referenced_tweets',
                    'user.fields' => 'id,name,profile_image_url',
                    //                    'expansions' => 'pinned_tweet_id',

                ]);
            if ($response->successful()) {
                $retweeters = $response->object()?->data;
            }
            $twitter_access_token = null;
        }

        $twitter_access_token = request()->session()->get('twitter_access_token') ?? null;
        if (isset($twitter_access_token)) {
            $twitter = Twitter::forApiV2()->usingCredentials($twitter_access_token['oauth_token'], $twitter_access_token['oauth_token_secret']);
            $user = $twitter->getUser(
                $twitter_access_token['user_id'],
                [
                    'user.fields' => 'entities',
                    'tweet.fields' => [],
                    'expansions' => [],
                ]
            );
        }

        //        dd (
        //            $event->metas->filter(fn($m) => $m->key = 'giveaways')->map(fn($m) => collect((array)json_decode($m?->content, false))->values())
        //        );

        $view->with([
            'twitter_access_token' => $twitter_access_token ? new Fluent($twitter_access_token) : null,
            'twitterUsers' => $twitterUsers,
            'retweeters' => $retweeters ?? null,
            'space' => $space,
            'title' => 'Proof of Participation',
            'giveaways' => $event->metas->filter(fn ($m) => $m->key = 'giveaways')->map(fn ($m) => collect((array) json_decode($m?->content, false))->values()),
        ]);
    }
}
