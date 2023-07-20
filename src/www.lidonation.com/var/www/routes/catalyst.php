<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnonymousBookmarkController;
use App\Http\Livewire\Catalyst\CatalystFundComponent;
use App\Http\Livewire\Catalyst\CatalystGroupsComponent;
use App\Http\Livewire\Catalyst\CatalystProposersComponent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Api\CatalystExplorer\UserController;
use App\Http\Controllers\ProjectCatalyst\CatalystFundsController;
use App\Http\Controllers\ProjectCatalyst\CatalystGroupsController;
use App\Http\Controllers\ProjectCatalyst\CatalystPeopleController;
use App\Http\Controllers\ProjectCatalyst\ProposalSearchController;
use App\Http\Controllers\ProjectCatalyst\CatalystReportsController;
use App\Http\Controllers\ProjectCatalyst\CatalystMyGroupsController;
use App\Http\Controllers\ProjectCatalyst\CatalystProposerController;
use App\Http\Controllers\ProjectCatalyst\CatalystBookmarksController;
use App\Http\Controllers\ProjectCatalyst\CatalystProposalsController;
use App\Http\Controllers\ProjectCatalyst\CatalystVoterToolController;
use App\Http\Controllers\ProjectCatalyst\CatalystAssessmentsController;
use App\Http\Controllers\ProjectCatalyst\CatalystMyBookmarksController;
use App\Http\Controllers\ProjectCatalyst\CatalystMyDashboardController;
use App\Http\Controllers\ProjectCatalyst\CatalystMyProposalsController;
use App\Http\Controllers\ProjectCatalyst\CatalystMyVotesController;
use App\Http\Controllers\ProjectCatalyst\CatalystUserProfilesController;
use App\Models\DraftBallot;
use Illuminate\Http\Request;

// Project Catalyst

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::get('/catalyst-proposals/users/{catalystUser}', fn () => view('catalyst.user'));
        Route::prefix('project-catalyst')->as('projectCatalyst.')->group(function () {
            Route::get('/reports', App\Http\Livewire\Catalyst\CatalystReportsComponent::class)
                ->name('reports');

            Route::get('/dashboard', App\Http\Livewire\Catalyst\CatalystDashboardComponent::class)
                ->name('dashboard');

            Route::get('/votes/ccv4', App\Http\Livewire\Catalyst\CatalystVotesComponent::class)
                ->name('votes.ccv4');

            Route::get('/voter-tool', App\Http\Livewire\Catalyst\CatalystVoterToolComponent::class)
                ->name('voterTool');

            Route::get('/bookmarks', App\Http\Livewire\Catalyst\CatalystBookmarksComponent::class)
                ->name('bookmarks');

            Route::get('/funds/{fund}/', CatalystFundComponent::class)
                ->name('fund');

            Route::get('/challenges/{fund}/', fn () => view('challenge'))
                ->name('challenge');

            Route::get('/groups', CatalystGroupsComponent::class)
                ->name('groups');

            Route::get('/users', CatalystProposersComponent::class)
                ->name('users');

            Route::get('/users/{catalystUser}', fn () => view('catalyst.user'))
                ->name('user');

            Route::get('/group/{catalystGroup}', fn () => view('catalyst.group'))
                ->name('group');
        });
        Route::prefix('/catalyst-explorer')->as('catalystExplorer.')->group(function () {
            Route::get('/login', fn () => Inertia::render('Auth/Login'))
                ->name('login');

            Route::get('/auth/login', [UserController::class, 'utilityLogin']);

            Route::get('/register', fn () => Inertia::render('Auth/Register'))
                ->name('register');

            Route::get('/reports', [CatalystReportsController::class, 'index'])
                ->name('reports');

            Route::get('/charts', fn () => Inertia::render('Charts'))
                ->name('charts');

            Route::get('/assessments', [CatalystAssessmentsController::class, 'index'])
                ->name('assessments');

            Route::get('/funds', [CatalystFundsController::class, 'index'])
                ->name('funds');

            Route::get('/funds/{fund}/', CatalystFundComponent::class)
                ->name('fund');

            Route::get('/challenges/{fund}/', fn () => view('challenge'))
                ->name('challenge');

            Route::get('/proposals', [CatalystProposalsController::class, 'index'])
                ->name('proposals');

            Route::get('/proposals/metrics/count/approved', [CatalystProposalsController::class, 'metricCountFunded']);
            Route::get('/proposals/metrics/count/paid', [CatalystProposalsController::class, 'metricCountTotalPaid']);
            Route::get('/proposals/metrics/count/completed', [CatalystProposalsController::class, 'metricCountCompleted']);

            Route::get('/proposals/metrics/sum/budget', [CatalystProposalsController::class, 'metricSumBudget']);
            Route::get('/proposals/metrics/sum/approved', [CatalystProposalsController::class, 'metricSumApproved']);
            Route::get('/proposals/metrics/sum/distributed', [CatalystProposalsController::class, 'metricSumDistributed']);
            Route::get('/proposals/metrics/sum/completed', [CatalystProposalsController::class, 'metricSumCompleted']);

            Route::get('people/{catalystUser:id}/metrics/sum/completed-proposals', [CatalystProposerController::class, 'getCompletedProposalCount']);
            Route::get('people/{catalystUser:id}/metrics/sum/outstanding-proposals', [CatalystProposerController::class, 'getOutsandingProposalCount']);
            Route::get('people/{catalystUser:id}/metrics/sum/outstanding-co-proposals', [CatalystProposerController::class, 'getCoProposalCount']);
            Route::get('people/{catalystUser:id}/metrics/sum/F10primary-proposals', [CatalystProposerController::class, 'getF10PrimaryProposalCount']);
            Route::get('people/{catalystUser:id}/metrics/sum/F10-co-proposals', [CatalystProposerController::class, 'getF10CoProposalCount']);

            Route::get('/people', [CatalystPeopleController::class, 'index'])
                ->name('people');

            Route::get('/groups', [CatalystGroupsController::class, 'index'])
                ->name('groups');

            Route::get('/voter-tool', [CatalystVoterToolController::class, 'index'])
                ->name('voterTool');

            Route::get('/proposals/{proposal:id}/bookmark', [CatalystProposalsController::class, 'bookmark']);
            Route::get('/bookmarks', [CatalystBookmarksController::class, 'index'])->name('bookmarks');

            Route::get('/bookmarks/{bookmarkCollection:id}', [CatalystBookmarksController::class, 'view'])
                ->name('bookmark`');

            Route::get('/draft-ballots/{draftBallot:id}', [CatalystBookmarksController::class, 'viewDraftBallot'])
                ->name('draftBallot.view');
            Route::get('/draft-ballot/{draftBallot:id}/edit', [CatalystBookmarksController::class, 'viewEditDraftBallot'])
            ->name('draftBallotEdit');

            // exports
            Route::get('/export/proposals', [CatalystProposalsController::class, 'exportProposals']);

            // Bookmarks
            Route::post('/bookmarks/items', [CatalystMyBookmarksController::class, 'createItem'])->name('bookmarkItem.create');
            Route::get('/export/bookmarked-proposals', [CatalystMyBookmarksController::class, 'exportBookmarks']);
            Route::delete('/bookmark-collection', [CatalystMyBookmarksController::class, 'deleteCollection'])->name('bookmarkCollection.delete');
            Route::delete('/bookmark-item/{bookmarkItem:id}', [CatalystMyBookmarksController::class, 'deleteItem'])->name('bookmarkItem.delete');

            Route::middleware(['auth.catalyst'])->prefix('/my')->group(function () {});
            Route::get('/cardano-treasury', App\Http\Livewire\Catalyst\CardanoTreasuryComponent::class)
                ->name('cardano-treasury');

            Route::middleware(['auth.catalyst'])->prefix('/my')->group(function () {
                Route::get('/bookmarks', [CatalystMyBookmarksController::class, 'index'])->name('myBookmarks');
                Route::post('/bookmarks/{bookmarkCollection:id}/create-ballot', [CatalystBookmarksController::class, 'createDraftBallotFromCollection'])
                ->name('bookmark.createBallot');
                Route::post('/draft-ballots', [CatalystBookmarksController::class, 'createDraftBallot'])
                ->name('createBallot');

                Route::get('/draft-ballots/{draftBallot:id}/edit', [CatalystBookmarksController::class, 'editDraftBallot'])
                ->name('draftBallot.edit');

                Route::post('/draft-ballots/{draftBallot:id}/rationale', [CatalystBookmarksController::class, 'storeDraftBallotRationale'])
                ->name('draftBallot.storeRationale');

                Route::get('/dashboard', [CatalystMyDashboardController::class, 'index'])
                    ->name('myDashboard');

                Route::get('/profiles', [CatalystUserProfilesController::class, 'index'])
                    ->name('myProfiles');

                Route::post('/profiles/{catalystUser:id}', [CatalystUserProfilesController::class, 'update']);

                Route::get('/proposals', [CatalystMyProposalsController::class, 'index'])
                    ->name('myProposals');

                Route::get('/proposals/{proposal:id}', [CatalystMyProposalsController::class, 'manage'])
                    ->name('myProposal');

                Route::post('/groups/{catalystGroup:id}', [CatalystGroupsController::class, 'update']);
                Route::get('/groups/{catalystGroup:id}/proposals', [CatalystMyGroupsController::class, 'proposals']);

                Route::get('/groups/create/{catalystUser:id}', [CatalystMyGroupsController::class, 'create']);
                Route::delete('/groups/{catalystGroup:id}/proposals/{proposal:id}', [CatalystMyGroupsController::class, 'removeProposal']);
                Route::put('/groups/{catalystGroup:id}/proposals', [CatalystMyGroupsController::class, 'addProposal']);

                Route::get('/groups/{catalystGroup:id}/members', [CatalystMyGroupsController::class, 'getMembers']);
                Route::delete('/groups/{catalystGroup:id}/members/{member:id}', [CatalystMyGroupsController::class, 'removeMembers']);
                Route::put('/groups/{catalystGroup:id}/members', [CatalystMyGroupsController::class, 'addMembers']);

                Route::post('/groups', [CatalystGroupsController::class, 'create']);
                Route::get('/groups', [CatalystMyGroupsController::class, 'index'])
                    ->name('myGroups');
                Route::get('/groups/{catalystGroup:id}', [CatalystMyGroupsController::class, 'manage'])
                    ->name('myGroup');
                Route::get('/groups/{catalystGroup:id}/sum/proposals', [CatalystMyGroupsController::class, 'metricProposalsCount']);
                Route::get('/groups/{catalystGroup:id}/sum/awarded', [CatalystMyGroupsController::class, 'metricTotalAwardedFunds']);
                Route::get('/groups/{catalystGroup:id}/sum/received', [CatalystMyGroupsController::class, 'metricTotalReceivedFunds']);
                Route::get('/groups/{catalystGroup:id}/sum/remaining', [CatalystMyGroupsController::class, 'metricTotalFundsRemaining']);


                // Votes
                Route::prefix('/votes')->as('votes.')->group(function () {
                    // Views
                    Route::get('/', [CatalystMyVotesController::class, 'index'])->name('index');
                    Route::get('/{vote}', [CatalystMyVotesController::class, 'view'])->name('view');

                    // CRUDs
                    Route::post('/store', [CatalystMyVotesController::class, 'store'])->name('store');
                    Route::patch('/{vote}/update', [CatalystMyVotesController::class, 'update'])
                        ->name('update');
                    Route::delete('/{vote}/delete', [CatalystMyVotesController::class, 'destroy'])->name('destroy');

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
