<?php

use App\Http\Controllers\RewardController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Project Catalyst

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::get('/rewards/login', [RewardController::class, 'loginForm'])
            ->name('rewards.login');

        Route::prefix('/rewards')->as('rewards.')
            ->middleware(['auth.reward'])
            ->group(function () {
                Route::get('/', [RewardController::class, 'index'])->name('index');

                Route::prefix('/withdrawals')->as('withdrawals.')->group(function () {
                    Route::get('/', [WithdrawalController::class, 'index'])
                        ->name('index');

                    Route::get('/{withdrawal:id}', [WithdrawalController::class, 'view'])
                        ->name('view');
                });

            });
    }
);
