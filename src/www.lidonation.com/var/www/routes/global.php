<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\WalletLoginController;
use App\Http\Livewire\Delegators\DelegatorsComponent;
use App\Livewire\BazaarComponent;
use App\Livewire\CommunityComponent;
use App\Livewire\FinancialDetails;
use App\Livewire\HomeComponent;
use App\Livewire\Library\PostComponent;
use App\Livewire\LibraryComponent;
use App\Livewire\LidoMinuteComponent;
use App\Livewire\LidoMinuteNftComponent;
use App\Livewire\PrivacyPolicyComponent;
use App\Livewire\Tags\TagsComponent;
use App\Livewire\TeamComponent;
use App\Livewire\WhatIsCardanoComponent;
use App\Livewire\WhatIsStakingComponent;
use App\Livewire\HowToBuyAdaComponent;
use App\Livewire\HowToStakeAdaComponent;
use App\Livewire\TaxonomyPageComponent;
use App\Models\Mint;
use App\Models\OnboardingContent;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\PostController;

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

        Route::get('/', HomeComponent::class)
            ->name('home');

        Route::get('/bazaar', BazaarComponent::class)
            ->name('bazaar');

        Route::get('/lido-minute', LidoMinuteComponent::class)->name('lido-minute')->middleware([]);

        Route::get('/lido-minute-nft', LidoMinuteNftComponent::class)
            ->name('lido-minute-nft');

        Route::get('/mint/lido-minute', function () {
            return view('mint-lido-minute');
        })->name('mint-lido-minute')->middleware([]);

        // library
        Route::get('/library', LibraryComponent::class)
            ->name('library');

        Route::get('/tags', TagsComponent::class)
            ->name('tags');

        Route::get('/posts/{post:slug}/', PostComponent::class)
            ->name('post');

        Route::get('/categories/{category:slug}/', TaxonomyPageComponent::class)
            ->name('category');

        Route::get('/tags/{tag:slug}/', TaxonomyPageComponent::class)
            ->name('tag');

        Route::get('/news', function () {
            return view('news');
        })->name('news');
        Route::get('/insights', function () {
            return view('insights');
        })->name('insights');
        Route::get('/reviews', function () {
            return view('reviews');
        })->name('reviews');

        Route::get('/community', CommunityComponent::class)->name('community');

        Route::get('/privacy-policy', PrivacyPolicyComponent::class)->name('privacyPolicy');

        Route::get('/team', TeamComponent::class)->name('team');
        Route::get('/financial-details', FinancialDetails::class)->name('financial-details');

        Route::post('/newsletter', [NewsletterController::class, 'store'])
            ->name('newsletter');

        Route::get('/what-is-cardano-and-how-does-it-use-the-blockchain', WhatIsCardanoComponent::class)->name('what-is-cardano');

        Route::get('/what-is-the-point-of-buying-ada-and-staking-in-cardano', WhatIsStakingComponent::class)->name('what-is-staking');

        Route::get('/how-to-buy-cardano-ada', HowToBuyAdaComponent::class)->name('how-to-buy-ada');

        Route::get('/how-to-stake-ada', HowToStakeAdaComponent::class)->name('how-to-stake-ada');
    }
);

Route::get('/delegators', DelegatorsComponent::class)->name('delegators');
// localize vendor routes
Route::prefix(LaravelLocalization::setLocale())->middleware('localeSessionRedirect', 'localizationRedirect', 'localeViewPath')->group(function () {
    Route::feeds('feeds/rss');

    // Portal
    Route::middleware(['auth:sanctum', 'verified'])->get('/portal', function () {
        $user = Auth::user();
        $mints = Mint::where('status', '!=', 'complete')->get();

        return view('dashboard', compact('user', 'mints'));
    })->name('portal');

    Route::middleware(['auth:sanctum', 'verified'])->get('/validate-wallet', function () {
        $user = Auth::user();

        return view('validate-wallet', compact('user'));
    })->name('validate');
    Route::middleware(['auth:sanctum', 'verified'])->get('/mint-phuffies', function () {
        $user = Auth::user();

        return view('mint-phuffies', compact('user'));
    })->name('mint');
    Route::middleware(['auth:sanctum', 'verified'])->get('/phuffy-vote', function () {
        $user = Auth::user();

        return view('phuffy-vote', compact('user'));
    })->name('phuffy-vote');

    require base_path('vendor/laravel/jetstream/routes/livewire.php');
    //    require base_path('vendor/laravel/fortify/routes/routes.php');
    Route::middleware(config('fortify.middleware', ['web']))->group(function () {
        $enableViews = config('fortify.views', true);

        // Authentication...
        if ($enableViews) {// localize vendor routes
            Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('login');
        }

        // Registration...
        if (Features::enabled(Features::registration())) {
            if ($enableViews) {
                Route::get('/register', [RegisteredUserController::class, 'create'])
                    ->middleware(['guest:'.config('fortify.guard')])
                    ->name('register');
            }
        }

        // Email Verification...
        if (Features::enabled(Features::emailVerification())) {
            if ($enableViews) {
                Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
                    ->middleware(['auth:'.config('fortify.guard')])
                    ->name('verification.notice');
            }
        }

        // Password Confirmation...
        if ($enableViews) {
            Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->middleware(['auth:'.config('fortify.guard')])
                ->name('lido.password.confirm');
        }

        Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
            ->middleware(['auth:'.config('fortify.guard')])
            ->name('lido.password.confirmation');

        // Two-Factor Authentication...
        if (Features::enabled(Features::twoFactorAuthentication())) {
            if ($enableViews) {
                Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
                    ->middleware(['guest:'.config('fortify.guard')])
                    ->name('lido.two-factor.login');
            }

            $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
                ? ['auth:'.config('fortify.guard'), 'password.confirm']
                : ['auth:'.config('fortify.guard')];

            Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
                ->middleware($twoFactorMiddleware)
                ->name('lido.two-factor.qr-code');

            Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
                ->middleware($twoFactorMiddleware)
                ->name('lido.two-factor.recovery-codes');
        }
    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/forgot-password', function (Request $request) {
    return view('auth.forgot-password', ['request' => $request]);
})->name('password.forgot');

Route::get('/reset-password/{token}', function (Request $request, $token) {
    return view('auth.reset-password', ['request' => $request, 'token' => $token]);
})->name('password.reset');

// Route::get('reset-password/{token}', ResetPasswordForm::class)->name('password.reset');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('password.update');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::comments();

