<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OAuthController extends Controller
{
    public function callback(): RedirectResponse
    {
        $oAuthUser = Socialite::driver('twitter-oauth-2')
            ->user();
        if ($oAuthUser instanceof \Laravel\Socialite\Two\User) {
            $setting = Setting::where('key', 'twitter_lido_access_token')->first();
            if (! $setting instanceof Setting) {
                $setting = new Setting;
            }
            $setting->key = 'twitter_lido_access_token';
            $setting->value = [
                'id' => $oAuthUser->id,
                'token' => $oAuthUser->token,
                'nickname' => $oAuthUser->nickname,
                'expiresIn' => $oAuthUser->expiresIn,
                'refreshToken' => $oAuthUser->refreshToken,
            ];
            $setting->save();
        }

        return redirect()->to('/voltaire');
    }

    public function redirect(): RedirectResponse
    {
        return Socialite::driver('twitter-oauth-2')->scopes(['space.read', 'offline.access'])->redirect();
    }
}
