<?php namespace App\Providers;

use App\Services\CardanoBlockfrostService;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider {

    public function boot()
    {
        //validation for wallet_address if it exists on chain
        $this->app['validator']->extend('wallet_address', function ($attribute, $value, $parameters)
        {
            $response = app(CardanoBlockfrostService::class)->get('addresses/'.$value, null);
            return $response->status() == 200 ? true : false;
        }, 'wallet address not valid');
    }

    public function register()
    {
        //
    }
}