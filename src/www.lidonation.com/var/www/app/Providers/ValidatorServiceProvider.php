<?php

namespace App\Providers;

use App\Services\CardanoBlockfrostService;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //validation for wallet_address if it exists on chain
        $this->app['validator']->extend('wallet_address', function ($attribute, $value, $parameters) {
            $response = app(CardanoBlockfrostService::class)->get('addresses/'.$value, null);

            return $response->status() == 200 ? true : false;
        }, 'Invalid wallet address');

        $this->app['validator']->extend('handle', function ($attribute, $value) {
            return preg_match('/^(\@)([a-z0-9_]{1,15})$/i', $value);
        }, 'Invalid handle');
    }

    public function register()
    {
        //
    }
}
