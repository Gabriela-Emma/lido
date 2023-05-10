<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Earn\EarnController;
use App\Http\Controllers\Earn\LearnController;
use App\Http\Controllers\Earn\LearningAnswerResponseController;
use App\Http\Controllers\Earn\LearningLessonController;
use App\Http\Controllers\Earn\LearningModulesController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\ModelTranslationController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReviewRatingImage;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\TaxonomyController;
use App\Http\Controllers\TwitterAttendanceController;
use App\Http\Controllers\VerifyWalletController;
use App\Http\Controllers\WalletLoginController;
use App\Http\Livewire\ContributeContent\ContributeContent;
use App\Http\Livewire\ContributeContent\ContributeRecordingComponent;
use App\Http\Livewire\ContributeContent\ContributeTranslation;
use App\Http\Livewire\ContributeContent\ContributeTranslations;
use App\Http\Livewire\Delegators\DelegatorsComponent;
use App\Http\Livewire\Library\LibraryComponent;
use App\Http\Livewire\LidoCatalystProposals\LidoCatalystProposals;
use App\Http\Livewire\Partners\PartnerDashboardComponent;
use App\Http\Livewire\PoolTool\PoolTool;
use App\Models\Mint;
use App\Models\OnboardingContent;
use App\Models\Podcast;
use App\Models\Proposal;
use App\Models\Review;
use App\Repositories\PostRepository;
use Atymic\Twitter\Facade\Twitter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
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

// Redirects
Route::get('/cardano-treasury-fund', fn () => redirect(LaravelLocalization::localizeURL('cardano-treasury')));

//Route::prefix(LaravelLocalization::setLocale())->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])->group(function () {

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ], function () {
        Route::get('/search/{term}', [GlobalSearchController::class, 'index'])
            ->name('search');

        Route::get('/search', [GlobalSearchController::class, 'index'])
        ->name('search');
        Route::get('/s',fn () => Inertia::render('GlobalSearch'));


        Route::get('/', function () {
            return view('home')->withShortcodes();
        })->name('home');

        Route::get('/subscribe', function () {
            return view('subscribe');
        })->name('subscribe');

        Route::get('/mint/lido-minute', function () {
            return view('mint-lido-minute');
        })->name('mint-lido-minute')->middleware([]);
        Route::get('/mint/lido-minute/{podcast}', function (Podcast $podcast) {
            return view('mint-lido-minute-episode', array_merge(compact('podcast'), request()->all()));
        })->name('mint-lido-minute-episode')->middleware([]);

        Route::get('/lido-minute', function () {
            return view('lido-minute');
        })->name('lido-minute')->middleware([]);

        Route::get('/lido-minute-nft', function () {
            return view('lido-minute-nft');
        })->name('lido-minute-nft');

        Route::get('/bazaar', function () {
            return view('bazaar');
        })->name('bazaar');

        Route::get('/privacy-policy', function () {
            return view('privacy-policy');
        })->name('privacyPolicy');

        Route::get('/governance-marathon', function () {
            return view('governance-marathon');
        })->name('governanceMarathon');

        Route::get('/cardano-treasury', App\Http\Livewire\Catalyst\CardanoTreasuryComponent::class)
            ->name('cardano-treasury');

        Route::prefix('/rewards')->as('rewards')->group(function () {
            Route::get('/', [RewardController::class, 'index']);
        });

        Route::prefix('/earn')->as('earn.')->group(function () {
            Route::get('/', [EarnController::class, 'index'])->name('home');

            Route::get('/learn', [LearnController::class, 'index'])->name('learn');
            Route::get('/learn/login', fn () => Inertia::render('Login'))
                ->name('learn.login');
            Route::get('/learn/register', fn () => Inertia::render('Register'))
                ->name('learn.register');

            Route::middleware(['auth.learn', 'userLearner'])->prefix('/learn')->group(function () {
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

                Route::get('/content', fn () => view('earn.contribute.content'))
                    ->name('content');

                Route::middleware([
                    'auth:'.config('fortify.guard'
                    )])->group(function () {
                        //                Route::get('/translation', ContributeTranslations::class)
                        //                    ->name('contributeTranslations');
                    });
            });

        });

        Route::get('/lido-catalyst-proposals', LidoCatalystProposals::class)
            ->name('lidoCatalystProposals');

        Route::get('/contribute-content', ContributeContent::class)
            ->name('contributeContent');
        Route::get('/contribute-content/audio/{post}', ContributeRecordingComponent::class)
            ->name('contributeAudio');

        Route::get('/contribute-content/translation', ContributeTranslations::class)
            ->middleware(['auth:'.config('fortify.guard')])
            ->name('contributeTranslations');
        Route::get('/contribute-content/translation/{translation}', ContributeTranslation::class)
            ->middleware(['auth:'.config('fortify.guard')])
            ->name('contributeTranslation');

        Route::get('/lido-minute/studio', ContributeTranslation::class)
            ->middleware(['auth:'.config('fortify.guard')])
            ->name('lidoMinuteStudio');

        // blog
        Route::get('/posts/{slug}/', function () {
            return view('post')->withShortcodes();
        })->name('post');

        //    Route::get('/posts/{slug}/', [PostController::class, 'show'])
        //        ->name('post');

        //    Route::get('/news/{post:slug}/', [PostController::class, 'show'])
        //        ->name('news');
        //    Route::get('/reviews/{review:slug}/', [PostController::class, 'show'])
        //        ->name('review');

        Route::get('/tidings', function () {
            return view('news');
        })->name('tidings');

        // Library
        //        Route::get('/library', function () {
        //            return view('library');
        //        })->name('library');

        Route::get('/library', LibraryComponent::class)
            ->name('library');
        Route::get('/tags', \App\Http\Livewire\Tags\TagsComponent::class)
            ->name('tags');

        Route::get('/news', function () {
            return view('news');
        })->name('news');
        Route::get('/insights', function () {
            return view('insights');
        })->name('insights');
        Route::get('/reviews', function () {
            return view('reviews')->withShortcodes();
        })->name('reviews');

        // Cardano Tools
        Route::get('/pool-tool', PoolTool::class)->name('pool-tool');

        Route::get('/lido-blockchain-labs/nairobi', fn () => view('lido-blockchain-labs'))->name('lido-blockchain-labs.nairobi');

        //        Route::get('/explorer', function () {
        //            return view('explorer');
        //        })->name('explorer');
        Route::get('/network-market-cap', function () {
            return view('network-market-cap');
        })->name('network-market-cap');

        // reviews
        Route::get('/reviews/{review}/summary-image/{hash}', [ReviewRatingImage::class, 'show'])
            ->name('reviewRatingImage');
        Route::get('/reviews/{review}', function (Review $review) {
            return view('review', compact('review'))->withShortcodes();
        })->name('review');

        // proposals
        Route::get('/proposals/{proposal}/', function (Proposal $proposal) {
            return view('proposal', compact('proposal'));
        })->name('proposal');

        // Archive News
        Route::get('/categories/{category}/', TaxonomyController::class.'@category');
        Route::get('/tags/{tag}/', TaxonomyController::class.'@tag');

        // Static Pages
        Route::get('/lido-staking-pool', function (PostRepository $posts) {
            $post = null;
            try {
                $post = $posts->get('about-the-pool');
            } catch (ModelNotFoundException $ex) {
                report($ex);
            }

            return view('lido-pool-detail')
                ->with(compact('post'));
        })->name('lido-pool');

        // Purpose driven pool
        Route::get('/purpose-driven-pool', function (PostRepository $posts) {
            $post = null;
            try {
                $post = $posts->get('purpose-driven-pool');
            } catch (ModelNotFoundException $ex) {
                report($ex);
            }

            return view('purpose-driven-pool')
                ->with(compact('post'));
        })->name('purpose-driven-pool');

        // financial-details
        Route::get('/financial-details', function (PostRepository $posts) {
            $post = null;
            try {
                $post = $posts->get('financial-details');
            } catch (ModelNotFoundException $ex) {
                report($ex);
            }

            return view('financial-details')
                ->with(compact('post'));
        })->name('financial-details');

        Route::get('/team', function () {
            return view('team');
        })->name('team');

        // Route::get('/rewards', App\Http\Livewire\Rewards\LidoRewardsComponent::class)
        //     ->name('rewards');

        Route::post('/delegators/missed-epoch', function (Request $request) {
            $account = $request->account;
            $refund = $request->refund;
            Mail::to(config('app.system_user_email'))->send(new class($account, $refund) extends Illuminate\Mail\Mailable
            {
                public function __construct(public $account, public $refund)
                {
                }

                public function content(): Content
                {
                    return new Content(
                        htmlString: "Send {$this->refund} to https://cexplorer.io/stake/{$this->account} ."
                    );
                }
            });
        })->name('missed-epoch');

        Route::get('/delegators', DelegatorsComponent::class)
            ->name('delegators');
        Route::get('/phuffycoin', function () {
            return view('phuffycoin');
        })->name('phuffycoin');
        Route::get('/phuffycoin/roadmap', function () {
            return view('phuffycoin-roadmap');
        })->name('phuffycoin-roadmap');

        Route::get('/connect', function () {
            return view('connect');
        })->name('connect');

        Route::get('/community', function () {
            return view('community');
        })->name('community');
        Route::get('/learning-center', function () {
            return view('learning-center');
        })->name('learning-center');
        Route::get('/noobs', function () {
            return view('noobs');
        })->name('noobs');
        Route::get('/blockchain-crypto-papers', function () {
            return view('learning-center');
        })->name('white-papers');
        Route::get('/blockchain-glossary', function () {
            return view('glossary');
        })->name('blockchain-glossary');

        // Getting Started Pages
        Route::prefix('posts')->group(function () {
            Route::get('/what-is-cardano-and-how-does-it-use-the-blockchain',
                fn () => redirect('/what-is-cardano-and-how-does-it-use-the-blockchain')
            );
            Route::get('/what-is-the-point-of-buying-ada-and-staking-in-cardano',
                fn () => redirect('/what-is-the-point-of-buying-ada-and-staking-in-cardano')
            );
            Route::get('/how-to-buy-cardano-ada',
                fn () => redirect('/how-to-buy-cardano-ada')
            );
            Route::get('/how-to-stake-ada',
                fn () => redirect('/how-to-stake-ada')
            );
        });
        Route::get('/what-is-cardano-and-how-does-it-use-the-blockchain', function (PostRepository $posts) {
            $post = null;
            try {
                $post = $posts->setModel(new OnboardingContent)->get('what-is-cardano-and-how-does-it-use-the-blockchain');
            } catch (ModelNotFoundException $ex) {
                report($ex);
            }

            return view('what-is-cardano')
                ->with(compact('post'));
        })->name('what-is-cardano');
        Route::get('/what-is-the-point-of-buying-ada-and-staking-in-cardano', function (PostRepository $posts) {
            $post = null;
            try {
                $post = $posts->setModel(new OnboardingContent)->get('what-is-the-point-of-buy-ada-and-staking-in-cardano');
            } catch (ModelNotFoundException $ex) {
                report($ex);
            }

            return view('what-is-staking')
                ->with(compact('post'));
        })->name('what-is-staking');
        Route::get('/how-to-buy-cardano-ada', function (PostRepository $posts) {
            $post = null;
            try {
                $post = $posts->setModel(new OnboardingContent)->get('how-do-i-buy-ada');
            } catch (ModelNotFoundException $ex) {
                report($ex);
            }

            return view('how-to-buy-ada')
                ->with(compact('post'));
        })->name('how-to-buy-ada');
        Route::get('/how-to-stake-ada', function (PostRepository $posts) {
            $post = null;
            try {
                $post = $posts->setModel(new OnboardingContent)->get('how-to-stake-your-ada');
            } catch (ModelNotFoundException $ex) {
                report($ex);
            }

            return view('how-to-stake-ada')
                ->with(compact('post'));
        })->name('how-to-stake-ada');

        // Lido Partners
        Route::prefix('partners')->as('partners.')->group(function () {
            Route::get('/', PartnerDashboardComponent::class)
                ->name('home');
            Route::get('/dashboard', PartnerDashboardComponent::class)
                ->name('dashboard');
        });
    });

// Wallet
Route::post('/wallet-login', [WalletLoginController::class, 'login']);
Route::prefix('validate-wallet')->group(function () {
    Route::post('/start',
        [VerifyWalletController::class, 'getValidationAddress'])
        ->name('validate-wallet');
    Route::post('/balance',
        [VerifyWalletController::class, 'getValidationWalletBalance'])
        ->name('validate-balance');
    Route::post('/delegation',
        [VerifyWalletController::class, 'getValidationWalletDelegation'])
        ->name('validate-delegation');
    Route::post('/refund',
        [VerifyWalletController::class, 'issueValidationWalletRefund'])
        ->name('validate-issue-refund');
    Route::get('/refund',
        [VerifyWalletController::class, 'getValidationWalletRefund'])
        ->name('validate-get-seed');
    Route::post('/nft-auth',
        [VerifyWalletController::class, 'hasLidoNft'])
        ->name('nft-auth');
});

//Route::get('test', function(){
//    $image = (new \App\Invokables\GenerateProposalImage)(Proposal::whereNotNull('funded_at')->inRandomOrder()->first())
//        ->windowSize(440, 440);
//        $image = base64_decode(str_replace('data:image/png;base64,', '', $image->base64Screenshot()));
//        $response = Response::make($image, 200);
//        $response->header('Content-Type', 'image/png');
//    return $response;
//});

Route::comments();

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
        $verificationLimiter = config('fortify.limiters.verification', '6,1');

        // Password Reset...
        if (Features::enabled(Features::resetPasswords())) {
            if ($enableViews) {
                // Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                //     ->middleware(['guest:'.config('fortify.guard')])
                //     ->name('password.request');

                // Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                //     ->middleware(['guest:'.config('fortify.guard')])
                //     ->name('password.reset');
            }
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

            Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['auth:'.config('fortify.guard'), 'signed', 'throttle:'.$verificationLimiter])
                ->name('verification.verify');
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

// localize post routes
Route::prefix(LaravelLocalization::setLocale())->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])->group(function () {
    //Route::post('/proposals/{proposal}/audio', PostController::class . '@storeAudio');
    Route::post('/posts/{post}/audio', PostController::class.'@storeAudio');
});
Route::post('/comment', [CommentController::class, 'store'])
    ->name('comment');
Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact');
Route::post('/newsletter', [NewsletterController::class, 'store'])
    ->name('newsletter');
Route::post('/stripe/get-intent', [StripeController::class, 'getIntent']);

// Twitter Routes
// Route::post('governance-marathon')
Route::controller(TwitterAttendanceController::class)->group(function () {
    Route::post('/ta/create', 'create')->name('createTwitterAttendance');
    //    Session::pu('requests', request()->all());
    redirect()->to('/governance-marathon');
});

Route::controller(OAuthController::class)->group(function () {
    Route::get('/auth/redirect/twitter', 'redirect')->name('oauth.redirect');
    Route::get('/auth/callback/twitter', 'callback')->name('oauth.callback');
});

Route::get('twitter/login', ['as' => 'twitter.login', static function () {
    $token = Twitter::forApiV1()->getRequestToken(route('twitter.callback'));

    if (isset($token['oauth_token_secret'])) {
        $url = Twitter::forApiV1()->getAuthenticateUrl($token['oauth_token']);

        Session::put('twitter_oauth_state', 'start');
        Session::put('twitter_oauth_type', 'proof_of_attendance');
        Session::put('twitter_oauth_request_token', $token['oauth_token']);
        Session::put('twitter_oauth_request_token_secret', $token['oauth_token_secret']);

        return Redirect::to($url);
    }

    return Redirect::route('twitter.error');
}]);

Route::get('twitter/callback', ['as' => 'twitter.callback', static function () {
    // You should set this route on your Twitter Application settings as the callback
    // https://apps.twitter.com/app/YOUR-APP-ID/settings
    if (Session::has('twitter_oauth_request_token')) {
        $twitter = Twitter::usingCredentials(session('twitter_oauth_request_token'), session('twitter_oauth_request_token_secret'));
        $token = $twitter->forApiV1()->getAccessToken(request('oauth_verifier'));

        if (! isset($token['oauth_token_secret'])) {
            return redirect()->route('governanceMarathon')->with('flash_error', 'We could not log you in on Twitter.');
        }

        // use new tokens
        $twitter = Twitter::usingCredentials($token['oauth_token'], $token['oauth_token_secret']);
        $credentials = $twitter->forApiV1()->getCredentials();

        if (is_object($credentials) && ! isset($credentials->error)) {
            // $credentials contains the Twitter user object with all the info about the user.
            // Add here your own user logic, store profiles, create new users on your tables...you name it!
            // Typically you'll want to store at least, user id, name and access tokens
            // if you want to be able to call the API on behalf of your users.

            // This is also the moment to log in your users if you're using Laravel's Auth class
            // Auth::login($user) should do the trick.

            Session::put('twitter_access_token', $token);

            return redirect()->route('governanceMarathon')->with('notice', 'Connected to twitter!');
        }
    }

    return Redirect::route('twitter.error')
        ->with('error', 'Crab! Something went wrong while signing you up!');
}]);

Route::get('/forgot-password', function (Request $request) {
    return view('auth.forgot-password', ['request' => $request]);
})->name('password.forgot');

Route::get('/reset-password/{token}', function (Request $request, $token) {
    return view('auth.reset-password', ['request' => $request, 'token' => $token]);
})->name('password.reset');

// Route::get('reset-password/{token}', ResetPasswordForm::class)->name('password.reset');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('password.update');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// translation
Route::post('/validate/user', [ModelTranslationController::class, 'validateUser']);
Route::get('/language-options', [ModelTranslationController::class, 'getLanguageOptions']);
Route::get('/model-content', [ModelTranslationController::class, 'getContent']);
Route::group(
    [
        'middleware' => ['auth:'.config('fortify.guard')],
    ], function () {
        Route::post('/translate', [ModelTranslationController::class, 'makeTranslation']);
        Route::patch('/translation', [ModelTranslationController::class, 'updateTranslation']);
    });

Route::post('/react/post/{post:id}', [PostController::class, 'createReaction']);
