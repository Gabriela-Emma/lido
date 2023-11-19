<?php

use App\Livewire\Contribute\ContributeComponent;
use App\Livewire\Contribute\ContributeRecordingComponent;
use App\Livewire\Contribute\LidonationContributorForm;
use App\Livewire\ContributeContent\ContributeContent;
use App\Livewire\ContributeContent\ContributeTranslation;
use App\Livewire\ContributeContent\ContributeTranslations;
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

            Route::get('/contribute/recording/', ContributeRecordingComponent::class)
                ->name('recording');

            // Route::get('/contribute/translation/', ContributeTranslation::class)
            //     ->name('translation');
        });

        Route::get('/contribute-content', ContributeContent::class)
            ->name('contributeContent');

        //    Route::get('/contribute-content/audio/{post}', ContributeRecordingComponent::class)
        //        ->name('contributeAudio');

        Route::get('/contribute-content/translation', ContributeTranslations::class)
            ->middleware(['auth:'.config('fortify.guard')])
            ->name('contributeTranslations');

        Route::get('/contribute-content/translation/{translation}', ContributeTranslation::class)
            ->middleware(['auth:'.config('fortify.guard')])
            ->name('contributeTranslation');
    }
);
