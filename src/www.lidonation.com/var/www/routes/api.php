<?php

use App\Http\Controllers\Api\CatalystExplorer;
use App\Http\Controllers\Api\CatalystExplorer\ProposalController;
use App\Http\Controllers\Api\Nfts\LidoMinuteNftsController;
use App\Http\Controllers\Api\Partners\PartnersController;
use App\Http\Controllers\Api\Phuffycoin\PhuffycoinController;
use App\Http\Controllers\Delegators\DelegatorController;
use App\Http\Controllers\Delegators\EveryEpochController;
use App\Http\Controllers\Earn\EarnController;
use App\Http\Controllers\Earn\LearnController;
use App\Http\Controllers\Earn\LearningLessonController;
use App\Http\Controllers\GenerateMnemonicPhraseController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\LidoStatsController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\QuestionResponseController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\SnippetController;
use App\Http\Integrations\Blockfrost\Requests\BlockfrostRequest;
use App\Inertia\CatalystExplorer\BookmarksController;
use App\Inertia\CatalystExplorer\MyBookmarksController;
use App\Inertia\CatalystExplorer\MyRankingController;
use App\Inertia\CatalystExplorer\ProposalsController;
use App\Inertia\CatalystExplorer\TalliesController;
use App\Models\CatalystExplorer\Ccv4BallotChoice;
use App\Models\Giveaway;
use App\Models\Reward;
use App\Models\User;
use App\Models\Withdrawal;
use App\Services\CardanoBlockfrostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
    ],
    function () {
        Route::get('/current', [DelegatorController::class, 'current']);
        Route::get('/{id}', [DelegatorController::class, 'index']);
    }
);
Route::group(
    [
        'prefix' => 'delegators',
        'middleware' => [],
    ],
    function () {
        Route::post('/create', [DelegatorController::class, 'create']);
        Route::post('/logout', [DelegatorController::class, 'logout']);
        Route::post('/login', [DelegatorController::class, 'login']);
    }
);

Route::group(
    [
        'prefix' => 'partners',
        'middleware' => [],
    ],
    function () {
        Route::post('/policies', [PartnersController::class, 'policies']);
        Route::post('/create', [PartnersController::class, 'create']);
        Route::post('/logout', [PartnersController::class, 'logout']);
        Route::post('/login', [PartnersController::class, 'login']);
    }
);


Route::group(
    [
        'prefix' => 'pool',
    ],
    function () {
        Route::get('/details', [DelegatorController::class, 'poolDetails']);
        Route::get('/blocks', [DelegatorController::class, 'poolBlocks']);
    }
);


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

Route::get('/ccv4/check-eligibility', function (Request $request) {
    $stake_address = $request->input('account');

    // check user by account and log them in
    $user = User::where('wallet_stake_address', $stake_address)->first();
    !is_null($user) ? Auth::login($user) : '';

    // build response based on ballots casted
    $response = [];
    $ballots = Ccv4BallotChoice::where('voter_id', $stake_address)->get();
    if ($ballots->isNotEmpty()) {
        $giveaway = Giveaway::with(['rules'])
            ->whereRelation('metas', ['key' => 'program', 'content' => 'ccv4'])->first();

        $rewards = Reward::where(
            'stake_address',
            $user?->wallet_stake_address
        )
            ->where('model_id', $giveaway?->id);

        $withdrawals = Withdrawal::with(['txs', 'metas'])
            ->whereRelation('metas', ['key' => 'withdrawal_tx'])
            ->withWhereHas('rewards', function ($query) use ($rewards) {
                $query->whereIn('id', $rewards->get()->pluck('id'));
            })
            ->get();

        // response array
        $response['eligibility'] = 'true';
        $response['rewards']['awarded'] = $rewards->whereIn('status', ['issued', 'processed'])->get();
        $response['rewards']['withdrawal_txs'] = $withdrawals->isNotEmpty() ? $withdrawals->map(fn ($withdrawal) => $withdrawal->withdrawal_tx) : [];
    } else {
        $response['eligibility'] = 'false';
        $response['rewards']['awarded'] = [];
        $response['rewards']['withdrawal_txs'] = [];
    }

    return json_encode($response);
});

Route::post('/ccv4/claim-rewards', function (Request $request) {
    // get the giveaway
    $giveaway = Giveaway::with(['rules'])
        ->whereRelation('metas', ['key' => 'program', 'content' => 'ccv4'])->first();

    // handle if $giveway is null and let the user know there is an error and to try again later
    if (is_null($giveaway)) {
        $error = [
            'name' => 'Giveaway Error',
            'message' => 'Giveaway error, try again later.',
            'type' => 'error',
        ];

        return json_encode($error);
    }

    $user = User::where('wallet_stake_address', $request->input('account'))->first();

    // use lucid to verify signature
    $ballots = Ccv4BallotChoice::where('voter_id', $request->input('account'));
    if ($request->has('tx')) {
        $ballots = $ballots->where('tx_hash', $request->input('tx'));
    }

    $ballots = $ballots->get();
    if ($ballots->isNotEmpty()) {
        if (!$user instanceof User) {
            $user = new User;
            $user->name = $request->account;
            $user->wallet_stake_address = $request->account;
            $user->wallet_address = $request->wallet_address;
            $user->email = $request->email ?? substr($request->account, -4) . '@anonymous.com';
            $user->password = Hash::make(Str::random(10));
            $user->save();
        }

        Auth::login($user);
    }

    $rewards = [];

    // for each rule in the giveaway
    $giveaway->rules?->each(function ($rule) use ($user, &$rewards, $giveaway) {

        // issue a reward to the user if one hasn't already been issued
        $reward = Reward::where(
            'stake_address',
            $user?->wallet_stake_address
        )
            ->where('model_id', $giveaway?->id)
            ->get();

        if (!$reward instanceof Reward) {
            $asset_name = trim($rule->subject, '.amount');
            $amount = $rule->predicate;

            $reward = new Reward;
            $reward->user_id = $user->id;
            $reward->asset = $asset_name;
            $reward->model_id = $giveaway->id;
            $reward->model_type = Giveaway::class;
            $reward->asset_type = 'ft';
            $reward->amount = $amount;
            $reward->status = 'issued';
            $reward->memo = 'voting reward';
            $reward->stake_address = $user->wallet_stake_address;

            $reward->save();
            $rewards[] = $reward;
        }
    });

    return compact('ballots', 'rewards');
});

// Rewards
Route::post('/rewards/login', [RewardController::class, 'login'])->name('rewardsApi.login');
Route::prefix('rewards')->as('rewardsApi.')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/', [PhuffycoinController::class, 'index'])->name('index');

        // withdrawals
        Route::prefix('withdrawals')->as('withdrawals.')->group(function () {
            Route::post('/withdrawals', [RewardController::class, 'withdrawals'])->name('index');

            Route::post('/withdrawals/withdraw', [RewardController::class, 'withdraw'])->name('withdraw');
            Route::post('/withdrawals/process', [RewardController::class, 'process'])->name('process');
            Route::post('/withdrawals/address', [RewardController::class, 'mintAddress'])->name('mintAddress');
        });
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
    ],
    function () {
        Route::get('/proposals', [ProposalController::class, 'index']);
    }
);

Route::group(
    [
        'middleware' => [],
    ],
    function () {
        Route::get('/epochs/latest/parameters', function (Request $request) {
            return CardanoBlockfrostService::queryBlockFrost('/epochs/latest/parameters');
        })->name('blockfrost-query');
        Route::get('cardano/config', function (Request $request) {
            $credentials = [
                'network_id' => config('cardano.network.network_id'),
                'app_url' => config('app.url'),
            ];

            return json_encode($credentials);
        })->name('cardano-config');

        Route::any('cardano/{relativePath?}', function (Request $request, $relativePath = null) {
            $uri = '/' . $relativePath;
            $frost = new BlockfrostRequest($uri);
            return $frost->send()->json();
        })->where('relativePath', ('.*'));
    }
);

// Catalyst Explorer Public API
Route::prefix('catalyst-explorer')->as('catalystExplorerApi.')
    ->middleware([])
    ->group(function () {
        Route::get('/funds', [CatalystExplorer\FundController::class, 'funds'])->name('funds');
        Route::get('/funds/{fund_id}', [CatalystExplorer\FundController::class, 'fund'])->name('fund');

        Route::get('/challenges', [CatalystExplorer\ChallengeController::class, 'challenges'])->name('challenges');
        Route::get('/challenges/{challenge_id}', [CatalystExplorer\ChallengeController::class, 'challenge'])->name('challenge');

        Route::get('/proposals', [CatalystExplorer\ProposalController::class, 'proposals'])->name('proposals');
        Route::get('/proposals/{proposal_id}', [CatalystExplorer\ProposalController::class, 'proposal']);

        Route::get('/proposals-ranks', [MyRankingController::class, 'ranks'])->name('proposals.ranks');

        Route::post('/people/claim', [CatalystExplorer\ProfileController::class, 'claim']);

        Route::get('/people', [CatalystExplorer\ProfileController::class, 'people']);
        Route::get('/people/{person_id}', [CatalystExplorer\ProfileController::class, 'person']);

        Route::get('/groups', [CatalystExplorer\GroupController::class, 'groups']);
        Route::get('/groups/{group_id}', [CatalystExplorer\GroupController::class, 'group']);

        Route::get('/tags', [CatalystExplorer\TagController::class, 'tags'])->name('tags');
        Route::get('/tags/{tag}', [CatalystExplorer\TagController::class, 'tag'])->name('tag');

        Route::get('/ledger-snapshots/latest', [CatalystExplorer\CatalystLedgerSnapshotController::class, 'latestCatalystLedgerSnapshot'])->name('latestCatalystLedgerSnapshots');
        Route::get('/ledger-snapshots', [CatalystExplorer\CatalystLedgerSnapshotController::class, 'catalystLedgerSnapshots'])->name('catalystLedgerSnapshots');
        Route::get('/ledger-snapshots/{snapshot_id}', [CatalystExplorer\CatalystLedgerSnapshotController::class, 'catalystLedgerSnapshot'])->name('catalystLedgerSnapshot');

        Route::post('/reports/follow', [CatalystExplorer\ReportController::class, 'follow']);

        Route::group([
            'prefix' => '/reports/comments',
        ], function () {
            Route::get('/{catalystReport:id}', [CatalystExplorer\ReportController::class, 'listComments']);
        });

        Route::post('/login', [CatalystExplorer\UserController::class, 'login'])->name('login');

        Route::post('/register', [CatalystExplorer\UserController::class, 'create']);

        // counts
        Route::get('/metrics/proposals/count/approved', [ProposalsController::class, 'metricCountFunded']);
        Route::get('/metrics/metrics/count/paid', [ProposalsController::class, 'metricCountTotalPaid']);
        Route::get('/metrics/metrics/count/completed', [ProposalsController::class, 'metricCountCompleted']);

        // sums
        Route::get('/metrics/metrics/sum/budget', [ProposalsController::class, 'metricSumBudget']);
        Route::get('/metrics/metrics/sum/approved', [ProposalsController::class, 'metricSumApproved']);
        Route::get('/metrics/metrics/sum/distributed', [ProposalsController::class, 'metricSumDistributed']);
        Route::get('/metrics/metrics/sum/completed', [ProposalsController::class, 'metricSumCompleted']);
        //        Route::post('/profiles', [CatalystUserProfilesController::class, 'update'])->name('myProfileUpdate');
    });

// Catalyst Explorer Private API
Route::prefix('catalyst-explorer')->as('catalystExplorerApi.')
    ->middleware([
        // 'auth:sanctum',
    ])
    ->group(function () {
        Route::post('/profiles/{catalystProfile:id}/follow', [CatalystExplorer\ProfileController::class, 'follow']);

        Route::post('/user', [CatalystExplorer\UserController::class, 'update']);

        Route::get('/branches', [CatalystExplorer\RepoController::class, 'getBranches']);

        Route::post('proposal/repo', [CatalystExplorer\RepoController::class, 'store']);
        Route::patch('proposal/repo', [CatalystExplorer\RepoController::class, 'updateRepo']);

        Route::get('/tallies', [TalliesController::class, 'index'])
            ->name('tallies');

        Route::get('/tallies/date', [TalliesController::class, 'getLastUpdated'])
            ->name('talliesUpdatedAt');
        Route::get('/tallies/sum', [TalliesController::class, 'getCatalystTallySum'])
            ->name('talliesSum');
        Route::get('/tallies/attachment-link', [TalliesController::class, 'getAttachementLink'])
            ->name('tallies.attachementLink');

        Route::prefix('proposals')->as('proposals.')->group(function () {
            Route::post('/login', [CatalystExplorer\UserController::class, 'login'])->name('login');

            Route::prefix('/{proposal:id}')->group(function () {
                Route::post('/repo', [CatalystExplorer\RepoController::class, 'store'])
                    ->name('storeRepo');

                Route::post('/quickpitch', [ProposalController::class, 'storeQuickpitch'])
                    ->name('storeQuickpitch');
            });
        });

        Route::prefix('/my')->group(function () {

            Route::get('/bookmarks', [MyBookmarksController::class, 'index'])
                ->name('myBookmarks');
        });

        Route::get('/my/draft-ballots', [BookmarksController::class, 'draftBallotIndex'])
            ->name('draftBallots');

        Route::get('/my/draft-ballots/{draftBallot:id}', [BookmarksController::class, 'getDraftBallot'])
            ->name('draftBallot');

        Route::post('/react/report/{catalystReport:id}', [CatalystExplorer\ReportController::class, 'createReaction']);

        Route::post('/logout', [CatalystExplorer\UserController::class, 'logout'])->name('logout');

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
    Route::post('/learn/waitList', [LearnController::class, 'waitList'])->name('learn.waitList');
    Route::get('/topics/{learningTopic:id}/lessons', [LearningLessonController::class, 'getLessons']);
    Route::middleware([
        'auth:sanctum',
    ])->prefix('/learn')->group(function () {
        Route::get('/learner-data', [LearnController::class, 'learnerData']);
    });
});

Route::prefix('promos')->as('promos.')->group(function () {
    Route::get('/', [PromoController::class, 'show'])->name('view');
    Route::post('/create', [PromoController::class, 'store'])->name('store');
});

Route::prefix('quizzes')->as('quizzes')
    ->middleware([])
    ->group(function () {

        Route::post('/giveaway', [QuestionResponseController::class, 'store'])
            ->name('responses.store.giveaway');
    });

Route::get('/generate-mnemonic-phrase', [GenerateMnemonicPhraseController::class, 'generate']);

// snippets
Route::get('/cache/snippets', [SnippetController::class, 'index'])->name('cache.snippets');

// every epoch


//search
Route::get('/s', [GlobalSearchController::class, 'index'])
    ->name('search');

// lido stats
Route::get('lido-stats', [LidoStatsController::class, 'index'])
    ->name('lidoStats');
