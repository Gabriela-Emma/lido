<?php

use App\Http\Controllers\Earn\EarnController;
use App\Models\User;
use App\Models\Reward;
use App\Models\EveryEpoch;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromoController;
use App\Models\Catalyst\Ccv4BallotChoice;
use App\Http\Controllers\RewardController;
use App\Services\CardanoBlockfrostService;
use App\Http\Controllers\SnippetController;
use App\Http\Controllers\Api\CatalystExplorer;
use App\Http\Controllers\Earn\LearnController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\QuestionResponseController;
use App\Http\Controllers\Earn\LearningLessonController;
use App\Http\Controllers\Delegators\DelegatorController;
use App\Http\Controllers\Api\Partners\PartnersController;
use App\Http\Controllers\GenerateMnemonicPhraseController;
use App\Http\Controllers\Api\Nfts\LidoMinuteNftsController;
use App\Http\Controllers\Api\Phuffycoin\PhuffycoinController;
use App\Http\Controllers\ProjectCatalyst\CatalystProjectsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Delegators
Route::group(
    [
        'prefix' => 'delegators',
        'middleware' => ['auth:sanctum'],
    ], function () {
        Route::get('/current', [DelegatorController::class, 'current']);
        Route::get('/{id}', [DelegatorController::class, 'index']);
    });
Route::group(
    [
        'prefix' => 'delegators',
        'middleware' => [],
    ], function () {
        Route::post('/create', [DelegatorController::class, 'create']);
        Route::post('/logout', [DelegatorController::class, 'logout']);
        Route::post('/login', [DelegatorController::class, 'login']);
    });

// Partners

Route::group(
    [
        'prefix' => 'partners',
        'middleware' => ['auth:sanctum'],
    ], function () {
        Route::get('/promos', [PromoController::class, 'index']);
        Route::get('/promos/{id}', [PromoController::class, 'read']);
    });
Route::group(
    [
        'prefix' => 'partners',
        'middleware' => [],
    ], function () {
        Route::post('/policies', [PartnersController::class, 'policies']);
        Route::post('/create', [PartnersController::class, 'create']);
        Route::post('/logout', [PartnersController::class, 'logout']);
        Route::post('/login', [PartnersController::class, 'login']);
    });

Route::group([
    'prefix' => 'phuffycoin',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('/', [PhuffycoinController::class, 'index']);
    Route::get('/available', [PhuffycoinController::class, 'available']);
    Route::post('/mint-address', [PhuffycoinController::class, 'mintAddress']);
    Route::post('/claim', [PhuffycoinController::class, 'claim']);
    Route::post('/claim/status', [PhuffycoinController::class, 'claimStatus']);
});

Route::group([
    'prefix' => 'webhooks',
], function () {
    Route::get('/faljla234208afad082304afsa0fd8', function () {
        // fetch tx metadata
        // update db with ballot
    });
});

Route::post('/ccv4/ballot', function (Request $request) {
    // get epoch
    $epoch = app(CardanoBlockfrostService::class)->get('epochs/latest/', null)->collect();

    $everyEpoch = EveryEpoch::where('epoch', $epoch['epoch'])->first();
    $user = User::where('wallet_stake_address', $request->input('account'))->first();

    // use lucid to verify signature
    $ballots = Ccv4BallotChoice::where('voter_id', $request->input('account'));
    if ($request->has('tx')) {
        $ballots = $ballots->where('tx_hash', $request->input('tx'));
    }

    $ballots = $ballots->get();
    if ($ballots->isNotEmpty()) {
        if (! $user instanceof User) {
            $user = new User;
            $user->name = $request->account;
            $user->wallet_stake_address = $request->account;
            $user->wallet_address = $request->wallet_address;
            $user->email = $request->email ?? substr($request->account, -4).'@anonymous.com';
            $user->password = Hash::make(Str::random(10));
            $user->save();
        }
        Auth::login($user);
    }

    return [
        'ballots' => $ballots,
        'reward' => Reward::where([
            'user_id' => $user?->id,
            'model_id' => $everyEpoch?->giveaway->id,
        ])->first(),
    ];
});

// Rewards
Route::post('/rewards/login', [RewardController::class, 'login']);
Route::group([
    'prefix' => 'rewards',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('/', [PhuffycoinController::class, 'index']);
    Route::post('/withdrawals/withdraw', [RewardController::class, 'withdraw']);
    Route::post('/withdrawals/process', [RewardController::class, 'process']);
    Route::post('/withdrawals', [RewardController::class, 'withdrawals']);
    Route::post('/withdrawals/address', [RewardController::class, 'mintAddress']);
});

Route::group([
    'prefix' => 'lido-minute-nft',
], function () {
    Route::post('/mint-price', [LidoMinuteNftsController::class, 'mintPrice']);
    Route::post('/mint-address', [LidoMinuteNftsController::class, 'mintAddress']);
    Route::post('/mint', [LidoMinuteNftsController::class, 'mint']);
    Route::post('/mint/status', [LidoMinuteNftsController::class, 'mintStatus']);
});

Route::group(
    [
        'prefix' => 'catalyst',
        'middleware' => ['localize'],
    ], function () {
        Route::get('/proposals', [ProposalController::class, 'index']);
    });

Route::group(
    [
        'middleware' => [],
    ], function () {
        Route::get('cardano/config', function (Request $request) {
            $credentials = [
                'poolId' => config('cardano.pool.hash'),
                'blockExplorer' => config('cardano.pool.block_explorer'),
                'blockfrostUrl' => config('services.blockfrost.baseUrl'),
                'projectId' => config('services.blockfrost.projectId'),
            ];

            return json_encode($credentials);
        });

        Route::any('cardano/{relativePath?}', function (CardanoBlockfrostService $frost, Request $request, $relativePath = null) {
            $method = $request->method();
            $uri = '/'.$relativePath;
            $data = $request->all();

            return $frost->request($method, $uri, $data);
        })->where('relativePath', ('.*'));
    });

// Catalyst Explorer Public API
Route::prefix('catalyst-explorer')->as('catalystExplorerApi.')
    ->middleware([])
    ->group(function () {
        Route::get('/funds', [CatalystExplorer\FundController::class, 'funds'])->name('funds');
        Route::get('/funds/{fund_id}', [CatalystExplorer\FundController::class, 'fund'])->name('fund');

        Route::get('/challenges', [CatalystExplorer\ChallengeController::class, 'challenges'])->name('challenges');
        Route::get('/challenges/{challenge_id}', [CatalystExplorer\ChallengeController::class, 'challenge'])->name('challenge');

        Route::get('/proposals', [CatalystExplorer\ProposalController::class, 'proposals']);
        Route::get('/proposals/{proposal_id}', [CatalystExplorer\ProposalController::class, 'proposal']);

        Route::post('/people/claim', [CatalystExplorer\ProfileController::class, 'claim']);

        Route::get('/people', [CatalystExplorer\ProfileController::class, 'people']);
        Route::get('/people/{person_id}', [CatalystExplorer\ProfileController::class, 'person']);

        Route::get('/groups', [CatalystExplorer\GroupController::class, 'groups']);
        Route::get('/groups/{group_id}', [CatalystExplorer\GroupController::class, 'group']);

        Route::get('/tags', [CatalystExplorer\TagController::class, 'tags'])->name('tags');
        Route::get('/tags/{tag}', [CatalystExplorer\TagController::class, 'tag'])->name('tag');

        Route::post('/reports/follow', [CatalystExplorer\ReportController::class, 'follow']);

        Route::group([
            'prefix' => '/reports/comments',
        ], function () {
            Route::get('/{catalystReport:id}', [CatalystExplorer\ReportController::class, 'listComments']);
        });

        Route::post('/login', [CatalystExplorer\UserController::class, 'login']);

        Route::post('/register', [CatalystExplorer\UserController::class, 'create']);

        // counts
        Route::get('/metrics/proposals/count/approved', [CatalystProjectsController::class, 'metricCountFunded']);
        Route::get('/metrics/metrics/count/paid', [CatalystProjectsController::class, 'metricCountTotalPaid']);
        Route::get('/metrics/metrics/count/completed', [CatalystProjectsController::class, 'metricCountCompleted']);

        // sums
        Route::get('/metrics/metrics/sum/budget', [CatalystProjectsController::class, 'metricSumBudget']);
        Route::get('/metrics/metrics/sum/approved', [CatalystProjectsController::class, 'metricSumApproved']);
        Route::get('/metrics/metrics/sum/distributed', [CatalystProjectsController::class, 'metricSumDistributed']);
        Route::get('/metrics/metrics/sum/completed', [CatalystProjectsController::class, 'metricSumCompleted']);
        //        Route::post('/profiles', [CatalystUserProfilesController::class, 'update'])->name('myProfileUpdate');
    });

// Catalyst Explorer Private API
Route::prefix('catalyst-explorer')->as('catalystExplorerApi.')
    ->middleware([
        'auth:sanctum',
    ])
    ->group(function () {
        Route::post('/profiles/{catalystProfile:id}/follow', [CatalystExplorer\ProfileController::class, 'follow']);

        Route::post('/user', [CatalystExplorer\UserController::class, 'update']);

        Route::get('/branches', [CatalystExplorer\RepoController::class, 'getBranches']);
        Route::post('proposal/repo', [CatalystExplorer\RepoController::class, 'saveRepo']);
        Route::patch('proposal/repo', [CatalystExplorer\RepoController::class, 'updateRepo']);

        Route::post('/react/report/{catalystReport:id}', [CatalystExplorer\ReportController::class, 'createReaction']);

        Route::post('/logout', [CatalystExplorer\UserController::class, 'logout']);

        Route::group([
            'prefix' => '/reports/comments',
        ], function () {
            Route::post('/{catalystReport:id}', [CatalystExplorer\ReportController::class, 'createComment']);
        });
    });

Route::prefix('earn')->as('earnApi.')->group(function () {
    Route::post('/wallet/update', [EarnController::class, 'storeWallet'])->name('wallet.add');
    Route::post('/learn/login', [LearnController::class, 'login']);
    Route::post('/learn/register', [LearnController::class, 'register']);
    Route::get('/topics/{learningTopic:id}/lessons', [LearningLessonController::class, 'getLessons']);
    Route::middleware([
        'auth:sanctum',
    ])->prefix('/learn')->group(function () {
        Route::get('/learner-data', [LearnController::class, 'learnerData']);
        //     Route::get('next-lesson-at', fn () => auth()?->user()?->next_lesson_at);
        //     Route::get(
        //         'rewards/sum',
        //         fn () => auth()?->user()?->rewards()
        //             ->where('model_type', LearningLesson::class)
        //             ->sum('amount')
        //     );
    });

});

Route::prefix('promos')->as('promos')
    ->middleware([
        'auth:sanctum',
    ])
    ->group(function () {
        Route::post('/create', [PromoController::class, 'store'])->name('store');
        Route::get('/', [PromoController::class, 'show']);
    });

Route::prefix('quizzes')->as('quizzes')
    ->middleware([])
    ->group(function () {
        Route::post('/questions/answers/responses', [QuestionResponseController::class, 'store'])
            ->name('responses.store');

        Route::post('/giveaway', [QuestionResponseController::class, 'store'])
            ->name('responses.store');
    });

Route::get('/generate-mnemonic-phrase', [GenerateMnemonicPhraseController::class, 'generate']);

// snippets
Route::get('/cache/snippets', [SnippetController::class, 'index'])->name('cache.snippets');


Route::get('/s', [GlobalSearchController::class, 'index'])
->name('search');
