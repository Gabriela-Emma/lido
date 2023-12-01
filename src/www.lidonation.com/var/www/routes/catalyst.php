<?php

use App\Http\Controllers\AnonymousBookmarkController;
use App\Http\Controllers\Api\CatalystExplorer\UserController;
use App\Inertia\CatalystExplorer\AssessmentsController;
use App\Inertia\CatalystExplorer\AttachmentsController;
use App\Inertia\CatalystExplorer\BookmarksController;
use App\Inertia\CatalystExplorer\ChallengeController;
use App\Inertia\CatalystExplorer\ChartsController;
use App\Inertia\CatalystExplorer\DRepsController;
use App\Inertia\CatalystExplorer\EventsController;
use App\Inertia\CatalystExplorer\FundController;
use App\Inertia\CatalystExplorer\FundsController;
use App\Inertia\CatalystExplorer\GroupsController;
use App\Inertia\CatalystExplorer\HomeController;
use App\Inertia\CatalystExplorer\MyBookmarksController;
use App\Inertia\CatalystExplorer\MyCommunityReviewsController;
use App\Inertia\CatalystExplorer\MyDashboardController;
use App\Inertia\CatalystExplorer\MyGroupsController;
use App\Inertia\CatalystExplorer\MyProposalsController;
use App\Inertia\CatalystExplorer\MyRankingController;
use App\Inertia\CatalystExplorer\MyVotesController;
use App\Inertia\CatalystExplorer\PeopleController;
use App\Inertia\CatalystExplorer\ProposalsController;
use App\Inertia\CatalystExplorer\ProposalSearchController;
use App\Inertia\CatalystExplorer\ProposerController;
use App\Inertia\CatalystExplorer\RegistrationsController;
use App\Inertia\CatalystExplorer\ReportsController;
use App\Inertia\CatalystExplorer\UserProfilesController;
use App\Inertia\CatalystExplorer\VoterToolController;
use App\Invokables\GenerateProposalImage;
use App\Livewire\CatalystExplorer\ProposalComponent;
use App\Livewire\CatalystExplorer\VotesComponent;
use App\Models\CatalystExplorer\Proposal;
use Illuminate\Support\Facades\Response;
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
        Route::get('/proposals/{proposal}/v3', ProposalComponent::class);
        Route::get('/proposals/{proposal}/', function (Proposal $proposal) {
            // related proposal in fund
            $relatedProposalsQuery = Proposal::with(['monthly_reports'])
                ->whereRelation('fund', 'parent_id', $proposal->fund?->parent_id)
                ->whereHas('users', fn ($q) => $q->whereIn('id', $proposal->users->pluck('id')))
                ->where('id', '!=', $proposal->id);
//
            $relatedProposals = $relatedProposalsQuery->limit(6)->get();

            // other proposals form same category
            return view('proposal', compact('proposal', 'relatedProposals'));
        })->name('proposal');

        Route::get('/catalyst-proposals/users/{catalystUser}', fn () => view('catalyst.user'));

        Route::prefix('project-catalyst')->as('projectCatalyst.')->group(function () {

            Route::get('/votes/ccv4', VotesComponent::class)
                ->name('votes.ccv4');

            Route::get('/challenges/{fund}/', fn () => view('challenge'))
                ->name('challenge');

            Route::get('/users/{catalystUser}', fn () => view('catalyst.user'))
                ->name('user');

            Route::get('/group/{catalystGroup}', fn () => view('catalyst.group'))
                ->name('group');
        });

        Route::prefix('/catalyst-explorer')->as('catalyst-explorer.')->group(function () {
            Route::get('/', [HomeController::class, 'index'])
                ->name('home');

            // Auth
            Route::get('/D', fn () => Inertia::render('Auth/Login'))
                ->name('login');

            Route::get('/utility-login', [UserController::class, 'utilityLogin'])
                ->name('login.utility');

            Route::get('/register', fn () => Inertia::render('Auth/Register'))
                ->name('register');

            Route::post('/login', [UserController::class, 'login'])->name('login.store');

            Route::post('/register', [UserController::class, 'create']);

            // Funds
            Route::prefix('/funds')->as('funds.')->group(function () {
                Route::get('/', [FundsController::class, 'index'])
                    ->name('index');

                Route::get('/{fund:slug}', [FundController::class, 'index'])
                    ->name('fund');


            });

            // Funds
            Route::prefix('/challenges')->as('funds.')->group(function () {
                Route::get('/{fund:slug}', [ChallengeController::class, 'index'])
                    ->name('challenge');
            });

            Route::get('/reports', [ReportsController::class, 'index'])
                ->name('reports');

            Route::get('/charts', [ChartsController::class, 'index'])
                ->name('charts');

            Route::get('/registrations', [RegistrationsController::class, 'index'])
                ->name('registrations');

            Route::get('/check-my-votes', [RegistrationsController::class, 'vote'])
                ->name('my-votes');


            Route::get('/registrations-data', [RegistrationsController::class, 'registrationsData'])
                ->name('registrations-data');

            Route::get('/votes-data', [RegistrationsController::class, 'getVoterData'])
                ->name('voter-data');

            Route::get('/assessments', [AssessmentsController::class, 'index'])
                ->name('assessments');

            // Route::get('/funds/{fund}/', CatalystFundComponent::class)
            //     ->name('fund');

            // Route::get('/challenges/{fund}/', fn () => view('challenge'))
            //     ->name('challenge');

            Route::get('/proposals', [ProposalsController::class, 'index'])
                ->name('proposals');

            Route::get('/events', [EventsController::class, 'index'])
                ->name('events');

            Route::post('/event/create', [EventsController::class, 'eventCreate'])
                ->name('event-create');

            Route::get('/filtered-proposals', [ProposalsController::class, 'getFilteredData'])
                ->name('filter-proposals');

            Route::get('/filtered-people', [PeopleController::class, 'getFilteredData'])
                ->name('filter-people');

            Route::get('/proposals/metrics/count/approved', [ProposalsController::class, 'metricCountFunded']);
            Route::get('/proposals/metrics/count/paid', [ProposalsController::class, 'metricCountTotalPaid']);
            Route::get('/proposals/metrics/count/completed', [ProposalsController::class, 'metricCountCompleted']);

            Route::get('/proposals/metrics/sum/budget', [ProposalsController::class, 'metricSumBudget']);
            Route::get('/proposals/metrics/sum/approved', [ProposalsController::class, 'metricSumApproved']);
            Route::get('/proposals/metrics/sum/distributed', [ProposalsController::class, 'metricSumDistributed']);
            Route::get('/proposals/metrics/sum/completed', [ProposalsController::class, 'metricSumCompleted']);

            Route::prefix('/people')->as('people.')->group(function () {
                Route::get('/', [PeopleController::class, 'index'])
                    ->name('index');

                Route::prefix('/{catalystUser:id}')->as('people.')->group(function () {
                    Route::get('/metrics/sum/completed-proposals', [ProposerController::class, 'getCompletedProposalCount']);
                    Route::get('/metrics/sum/outstanding-proposals', [ProposerController::class, 'getOutstandingProposalCount']);
                    Route::get('/metrics/sum/outstanding-co-proposals', [ProposerController::class, 'getCoProposalCount']);
                    Route::get('/metrics/sum/f11primary-proposals', [ProposerController::class, 'getF11PrimaryProposalCount']);
                    Route::get('/metrics/sum/f11-co-proposals', [ProposerController::class, 'getF11CoProposalCount']);
                });
            });

            //DReps
            Route::prefix('/dreps')->as('dReps.')->group(function () {
                Route::get('/', [DRepsController::class, 'index'])
                    ->name('index');
                Route::get('/signup', [DRepsController::class, 'signUp'])
                    ->name('signUp');
                Route::post('/store', [DRepsController::class, 'store'])
                    ->name('store');
            });

            //catalyst charts metrics
            Route::prefix('/metrics')->as('metrics.')->group(function () {
                Route::get('/adaPowerRanges', [ChartsController::class, 'metricAdaPowerRanges'])
                    ->name('adaPowerRanges');
                Route::get('/largestFundedProposalObject', [ChartsController::class, 'metricLargestFundedProposalObject'])
                    ->name('largestFundedProposalObject');
                Route::get('/fundedOver75KCount', [ChartsController::class, 'metricFundedOver75KCount'])
                    ->name('fundedOver75KCount');
                Route::get('/membersAwardedFundingCount', [ChartsController::class, 'metricMembersAwardedFundingCount'])
                    ->name('membersAwardedFundingCount');
                Route::get('/fullyDisbursedProposalsCount', [ChartsController::class, 'metricFullyDisbursedProposalsCount'])
                    ->name('fullyDisbursedProposalsCount');
                Route::get('/completedProposalsCount', [ChartsController::class, 'metricCompletedProposalsCount'])
                    ->name('completedProposalsCount');
                Route::get('/total-registrations-ada-power', [ChartsController::class, 'metricTotalRegisteredAdaPower'])
                    ->name('totalRegisteredAdaPower');
                Route::get('/registeredAdaNotVoted', [ChartsController::class, 'metricSumAdaRegisteredNotVoted'])
                    ->name('registeredAdaNotVoted');
                Route::get('/registeredWalletsNotVoted', [ChartsController::class, 'metricSumWalletsRegisteredNotVoted'])
                    ->name('registeredWalletsNotVoted');
                Route::get('/total-registrations', [ChartsController::class, 'metricTotalRegistrations'])
                    ->name('totalRegistrations');
                Route::get('/total-delegation-registrations', [ChartsController::class, 'metricTotalDelegationRegistrations'])
                    ->name('totalDelegationRegistrations');
                Route::get('/total-delegation-registrations-ada-power', [ChartsController::class, 'metricTotalDelegationRegistrationsAdaPower'])
                    ->name('totalDelegationRegistrationsAdaPower');
                Route::get('/total-yes-votes', [ChartsController::class, 'metricsTotalYesVotes'])
                    ->name('totalYesVotes');
                Route::get('/total-no-votes', [ChartsController::class, 'metricsTotalNoVotes'])
                    ->name('totalNoVotes');
                Route::get('/votes-casted-average', [ChartsController::class, 'metricVotesCastAverage'])
                    ->name('votesCastAverage');
                Route::get('/votes-casted-mode', [ChartsController::class, 'metricVotesCastMode'])
                    ->name('votesCastMode');
                Route::get('/votes-casted-median', [ChartsController::class, 'metricVotesCastMedian'])
                    ->name('votesCastMedian');
                Route::get('/total-registered-and-voted', [ChartsController::class, 'metricTotalRegisteredAndVoted'])
                    ->name('totalRegisteredAndVoted');
                Route::get('/total-registered-and-never-voted', [ChartsController::class, 'metricTotalRegisteredAndNeverVoted'])
                    ->name('totalRegisteredAndNeverVoted');
                Route::get('/votes-casted-ranges', [ChartsController::class, 'metricVotesCastRanges'])
                    ->name('votesCastRanges');
            });

            Route::get('/attachments/voting-powers', [AttachmentsController::class, 'votingPowersAttachemnt'])
                ->name('attachments.votingPowers');

            Route::get('/charts/topFundedProposals', [ChartsController::class, 'getTopFundedProposals'])
                ->name('topFundedProposals');

            Route::get('/charts/getTopFundedTeams', [ChartsController::class, 'getTopFundedTeams'])
                ->name('topFundedTeams');

            Route::get('/groups', [GroupsController::class, 'index'])
                ->name('groups');

            Route::get('/filtered-groups', [GroupsController::class, 'getFilteredData'])
                ->name('filter-groups');

            Route::get('/voter-tool', [VoterToolController::class, 'index'])
                ->name('voter-tool');

            Route::get('/voter-tool/counts', [VoterToolController::class, 'setCounts'])
                ->name('voterTool.counts');

            Route::get('/voter-tool/taxomomies', [VoterToolController::class, 'setTaxonomy'])
                ->name('voterTool.taxomomy');

            Route::get('/proposals/{proposal:id}/bookmark', [ProposalsController::class, 'bookmark']);
            Route::get('/bookmarks', [BookmarksController::class, 'index'])
                ->name('bookmarks');

            Route::get('/bookmarks/{bookmarkCollection:id}', [BookmarksController::class, 'view'])
                ->name('bookmark`');

            Route::get('/draft-ballots/{draftBallot:id}', [BookmarksController::class, 'viewDraftBallot'])
                ->name('draftBallot.view');
            Route::get('/draft-ballot/{draftBallot:id}/update', [BookmarksController::class, 'viewUpdateDraftBallot'])
                ->name('draftBallotUpdate.view');

            // exports
            Route::get('/export/proposals', [ProposalsController::class, 'exportProposals']);
            Route::get('/download/proposals', [ProposalsController::class, 'downloadProposals'])
                ->name('download.proposals');

            // Bookmarks
            Route::post('/bookmarks/items', [MyBookmarksController::class, 'createItem'])->name('bookmarkItem.create');
            Route::get('/export/bookmarked-proposals', [MyBookmarksController::class, 'exportBookmarks']);
            Route::delete('/bookmark-collection', [MyBookmarksController::class, 'deleteCollection'])->name('bookmarkCollection.delete');
            Route::delete('/bookmark-item/{bookmarkItem:id}', [MyBookmarksController::class, 'deleteItem'])->name('bookmarkItem.delete');

            Route::middleware(['auth.catalyst'])->prefix('/my')->group(function () {
            });

            Route::middleware(['auth.catalyst'])->prefix('/my')->group(function () {
                Route::post('/bookmarks/{bookmarkCollection:id}/create-ballot', [BookmarksController::class, 'createDraftBallotFromCollection'])
                    ->name('bookmark.createBallot');
                Route::post('/draft-ballots', [BookmarksController::class, 'createDraftBallot'])
                    ->name('createBallot');

                Route::get('/draft-ballots/{draftBallot:id}/edit', [BookmarksController::class, 'editDraftBallot'])
                    ->name('draftBallot.edit');

                Route::delete('/draft-ballots/{draftBallot:id}/delete', [BookmarksController::class, 'deleteDraftBallot'])
                    ->name('draftBallot.delete');

                Route::patch('/draft-ballot/{draftBallot:id}/update', [BookmarksController::class, 'updateDraftBallot'])
                    ->name('draftBallot.update');

                Route::post('/draft-ballots/{draftBallot:id}/rationale', [BookmarksController::class, 'storeDraftBallotRationale'])
                    ->name('draftBallot.storeRationale');

                Route::get('/dashboard', [MyDashboardController::class, 'index'])
                    ->name('myDashboard');

                Route::get('/bookmarks', [fn () => Inertia::render('Auth/MyBookmarks')])
                    ->name('myBookmarks');

                Route::get('/draft-ballots', fn () => Inertia::render('Auth/MyDraftBallots'))
                    ->name('myDraftBallots');

                Route::get('/profiles', [UserProfilesController::class, 'index'])
                    ->name('myProfiles');

                Route::post('/profiles/{catalystUser:id}', [UserProfilesController::class, 'update']);

                Route::get('/proposals', [MyProposalsController::class, 'index'])
                    ->name('myProposals');
                Route::get('/proposals/{proposal:id}', [MyProposalsController::class, 'manage'])
                    ->name('myProposal');

                Route::get('/reviews', [MyCommunityReviewsController::class, 'index'])
                    ->name('myCommunityReviews');
                Route::post('/reviews/{assessment}', [MyCommunityReviewsController::class, 'replyToReview'])
                    ->name('replyToMyCommunityReview');
                Route::delete('/reviews/{assessment}', [MyCommunityReviewsController::class, 'destroyResponse'])
                    ->name('destroyResponseToMyCommunityReview');
                Route::patch('/reviews/{assessment}', [MyCommunityReviewsController::class, 'editResponse'])
                    ->name('editResponseToMyCommunityReview');

                Route::post('/groups/{catalystGroup:id}', [GroupsController::class, 'update']);
                Route::get('/groups/{catalystGroup:id}/proposals', [MyGroupsController::class, 'proposals']);

                Route::get('/groups/create/{catalystUser:id}', [MyGroupsController::class, 'create']);
                Route::delete('/groups/{catalystGroup:id}/proposals/{proposal:id}', [MyGroupsController::class, 'removeProposal']);
                Route::put('/groups/{catalystGroup:id}/proposals', [MyGroupsController::class, 'addProposal']);

                Route::get('/groups/{catalystGroup:id}/members', [MyGroupsController::class, 'getMembers']);
                Route::delete('/groups/{catalystGroup:id}/members/{member:id}', [MyGroupsController::class, 'removeMembers']);
                Route::put('/groups/{catalystGroup:id}/members', [MyGroupsController::class, 'addMembers']);

                Route::post('/groups', [GroupsController::class, 'create']);
                Route::get('/groups', [MyGroupsController::class, 'index'])
                    ->name('myGroups');
                Route::get('/groups/{catalystGroup:id}', [MyGroupsController::class, 'manage'])
                    ->name('myGroup');
                Route::get('/groups/{catalystGroup:id}/sum/proposals', [MyGroupsController::class, 'metricProposalsCount']);
                Route::get('/groups/{catalystGroup:id}/sum/awarded', [MyGroupsController::class, 'metricTotalAwardedFunds']);
                Route::get('/groups/{catalystGroup:id}/sum/received', [MyGroupsController::class, 'metricTotalReceivedFunds']);
                Route::get('/groups/{catalystGroup:id}/sum/remaining', [MyGroupsController::class, 'metricTotalFundsRemaining']);

                // Votes
                Route::prefix('/votes')->as('votes.')->group(function () {
                    // Views
                    Route::get('proposal/{proposal:id}', [MyVotesController::class, 'index'])->name('index');
                    Route::get('/{vote}', [MyVotesController::class, 'view'])->name('view');

                    // CRUDs
                    Route::post('/store', [MyVotesController::class, 'store'])->name('store');
                    Route::patch('/{vote}/update', [MyVotesController::class, 'update'])
                        ->name('update');
                    Route::delete('/{vote}/delete', [MyVotesController::class, 'destroy'])->name('destroy');
                });

                // Ranks
                Route::prefix('/ranks')->as('ranks.')->group(function () {
                    // Views
                    Route::get('/', [MyRankingController::class, 'index'])->name('index');
                    Route::get('/{rank}', [MyRankingController::class, 'view'])->name('view');

                    // CRUDs
                    Route::post('/store', [MyRankingController::class, 'store'])->name('store');
                    Route::patch('/{rank}/update', [MyRankingController::class, 'update'])
                        ->name('update');
                    Route::delete('/{rank}/delete', [MyRankingController::class, 'destroy'])->name('destroy');
                });
            });
        });
    }
);
Route::prefix('project-catalyst')->group(function () {
    Route::get('/bookmarks/share/{anonymousBookmark}', [AnonymousBookmarkController::class, 'show']);
    Route::get('/bookmarks/share/{anonymousBookmark}', [AnonymousBookmarkController::class, 'show']);
    Route::post('/bookmarks/share', [AnonymousBookmarkController::class, 'share']);
    Route::post('/proposals/search/bookmarks', [ProposalSearchController::class, 'bookmarks']);
});
