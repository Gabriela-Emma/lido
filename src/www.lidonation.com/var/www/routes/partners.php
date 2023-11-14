<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromoController;
use App\Livewire\Partners\LoginComponent;
use App\Livewire\Partners\PartnerDashboardComponent;
use App\Http\Controllers\Api\Partners\PartnersController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::get('/partners/login', LoginComponent::class)
            ->name('partners.login');

        Route::prefix('partners')->as('partners.')->group(function () {
            Route::get('/', PartnerDashboardComponent::class)
                ->name('home');

        });
    }
);
