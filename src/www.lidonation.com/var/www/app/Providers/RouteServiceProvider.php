<?php

namespace App\Providers;

use App\Models\BookmarkCollection;
use App\Models\CatalystExplorer\CatalystVote;
use App\Models\DraftBallot;
use App\Models\LearningLesson;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Vinkla\Hashids\Facades\Hashids;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        Route::bind('bookmarkCollection', function ($value, $route) {
            return $this->getModel(BookmarkCollection::class, $value);
        });

        Route::bind('draftBallot', function ($value, $route) {
            return $this->getModel(DraftBallot::class, $value);
        });

        Route::bind('catalystVote', function ($value, $route) {
            return $this->getModel(CatalystVote::class, $value);
        });

        Route::bind('learningLesson', function ($value, $route) {
            return $this->getModel(LearningLesson::class, $value);
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/global.php'));

            Route::middleware('web')
                ->group(base_path('routes/delegators.php'));

            Route::middleware('web')
                ->group(base_path('routes/phuffycoin.php'));

            Route::middleware('web')
                ->group(base_path('routes/contribute.php'));

            Route::middleware('web')
                ->group(base_path('routes/catalyst.php'));

            Route::middleware('web')
                ->group(base_path('routes/earn.php'));

            Route::middleware('web')
                ->group(base_path('routes/rewards.php'));

            Route::middleware('web')
                ->group(base_path('routes/partners.php'));

            Route::middleware('web')
                ->group(base_path('routes/rewards.php'));

            Route::middleware('web')
                ->group(base_path('routes/vendors.php'));
        });
    }

    private function getModel($model, $routeKey)
    {
        $id = Hashids::connection($model)->decode($routeKey)[0] ?? null;
        $modelInstance = resolve($model);

        return $modelInstance->findOrFail($id);
    }
}
