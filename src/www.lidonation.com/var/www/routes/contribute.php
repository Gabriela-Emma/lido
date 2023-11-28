<?php

use App\Livewire\Contribute\ContributeComponent;
use App\Livewire\Contribute\ContributeRecordingComponent;
use App\Livewire\Contribute\LidonationContributorForm;
use App\Livewire\Contribute\Translations\ContributeContent;
use App\Livewire\Contribute\Translations\ContributeTranslation;
use App\Livewire\Contribute\Translations\ContributeTranslations;
use Illuminate\Support\Facades\Route;
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

        Route::prefix('contribute')->as('contribute.')->group(function () {
            Route::get('/', ContributeComponent::class)
                ->name('home');

            Route::get('/signup', LidonationContributorForm::class)->name('signupForm');

            Route::prefix('/translations')->as('translations.')
                ->middleware(['auth:sanctum'])
                ->group(function () {
                    Route::get('/', ContributeTranslations::class)
                        ->name('index');

                    Route::get('/{translation:id}/edit', ContributeTranslation::class)
                        ->name('edit');
                });

            Route::get('/recording/', ContributeRecordingComponent::class)
                ->name('recording');
        });

        // Route::get('/contribute-content', ContributeContent::class)
        //     ->name('contributeContent');

        //    Route::get('/contribute-content/audio/{post}', ContributeRecordingComponent::class)
        //        ->name('contributeAudio');

        // Route::get('/contribute-content/translations', ContributeTranslations::class)
        // ->middleware(['auth:'.config('fortify.guard')])
        // ->name('contributeTranslations');

    }
);
