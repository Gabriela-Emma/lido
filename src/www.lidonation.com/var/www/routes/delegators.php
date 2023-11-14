<?php

use App\Livewire\LidoPoolDetails;
use Illuminate\Support\Facades\Route;
use App\Inertia\Delegators\HomeController;
use App\Http\Controllers\QuestionResponseController;
use App\Http\Controllers\Delegators\EveryEpochController;
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
        Route::prefix('/delegators')->as('delegators.')->group(function () {
            Route::get('/', [HomeController::class, 'index'])
                ->name('home');
        });

        Route::prefix('everyEpoch')->as('epoch.')
            ->middleware([])
            ->group(function () {
                Route::get('/everyEpoch', [EveryEpochController::class, 'getEveryEpoch'])->name('epochDetails');
                Route::get('/epoch-quiz', [EveryEpochController::class, 'getEpochQuestion'])->name('quiz');
                Route::get('/epoch-question-response', [EveryEpochController::class, 'epochQuestionAnswer'])
                    ->name('answerResponse');
                Route::post('/questions/answers/responses', [QuestionResponseController::class, 'store'])
                    ->name('response.store');
                Route::get('/epoch-rewards-pot', [EveryEpochController::class, 'getEpochRewardsPot'])->name('rewardsPot');
                Route::get('/epoch-reward-template', [EveryEpochController::class, 'getRewardTemplate'])->name('rewardsTemplate');
                Route::post('/epoch-reward-claim', [EveryEpochController::class, 'claimEveryEpochReward'])->name('rewardsClaim');
            });

        Route::get('/lido-staking-pool', LidoPoolDetails::class)->name('lido-pool');
    }
);
