<?php

namespace App\Jobs;

use App\Models\Setting;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class RefreshLidoTwitterToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     *
     * @throws GuzzleException
     */
    public function handle(): void
    {
        $twitterAccessTokenSetting = Setting::where('key', 'twitter_lido_access_token')->first();
        if (! $twitterAccessTokenSetting instanceof  Setting) {
            return;
        }

        $twitter_access_token = $twitterAccessTokenSetting?->value;
        $auth = base64_encode(config('services.twitter.client_id').':'.config('services.twitter.client_secret'));
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
            'Authorization' => "Basic {$auth}",
        ])->bodyFormat('form_params')->post('https://api.twitter.com/2/oauth2/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $twitter_access_token['refreshToken'],
        ]);

        if ($response->successful()) {
            $oAuthUser = $response?->object();
            $twitterAccessTokenSetting->value = [
                'id' => $twitter_access_token['id'],
                'token' => $oAuthUser->access_token,
                'nickname' => $twitter_access_token['nickname'],
                'expiresIn' => $oAuthUser->expires_in,
                'refreshToken' => $oAuthUser->refresh_token,
            ];
            $twitterAccessTokenSetting->save();
        }
    }
}
