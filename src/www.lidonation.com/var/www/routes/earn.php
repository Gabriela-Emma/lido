<?php

use App\Inertia\Earn\EarnController;
use App\Inertia\Earn\LearnController;
use App\Inertia\Earn\LearningAnswerResponseController;
use App\Inertia\Earn\LearningLessonController;
use App\Inertia\Earn\LearningModulesController;
use App\Livewire\Contribute\Earn\Content;
use App\Livewire\Earn\CcvComponent;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Project Catalyst

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::prefix('/earn')->as('earn.')->group(function () {
            Route::get('/', [EarnController::class, 'index'])->name('home');

            Route::get('/wallet/add', [EarnController::class, 'addWallet'])->name('wallet.add');
            Route::get('/duplicate-account', [EarnController::class, 'duplicateAccount'])->name('learn.duplicate');
            Route::get('/nft-awarded', [EarnController::class, 'awardNft'])->name('learn.nft.awarded');

            Route::get('/ccv4', CcvComponent::class)
                ->name('ccv4');

            Route::get('/learn', [LearnController::class, 'index'])
                ->name('learn');
            Route::get('/learn/login', fn () => Inertia::render('Login'))
                ->name('learn.login');
            Route::get('/learn/register', fn () => Inertia::render('Register')->with('registerOpen', config('app.slte.registration_open')))
                ->name('learn.register');

            Route::middleware(['auth.learn', 'userLearner', 'verified', 'duplicateAccount'])->prefix('/learn')->group(function () {
                Route::get('modules', [LearningModulesController::class, 'index'])
                    ->name('learn.modules.index');
                Route::get('modules/{learningModule:slug}', [LearningModulesController::class, 'show'])
                    ->name('learn.modules.view');
                Route::get('lessons/{learningLesson:id}', [LearningLessonController::class, 'show'])
                    ->name('learn.lesson.view');

                Route::get('/answer-response/responses', [LearningAnswerResponseController::class, 'index']);
                Route::post('/answer-response/store/answer', [LearningAnswerResponseController::class, 'storeAnswer']);
            });

            Route::prefix('/contribute')->as('contribute.')->group(function () {
                Route::get('/', fn () => view('earn.contribute'))
                    ->name('home');

                Route::get('/content', Content::class)
                    ->name('content');

                Route::middleware([
                    'auth:'.config('fortify.guard'
                    )])->group(function () {
                        //                Route::get('/translation', ContributeTranslations::class)
                        //                    ->name('contributeTranslations');
                    });
            });
        });
    }
);
