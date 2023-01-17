<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use App\Services\CardanoBlockfrostService;
use App\Services\CardanoMintService;
use App\Services\PhuffycoinService;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

//use Spatie\NovaTranslatable\Translatable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $this->app->singleton('cardanoService', fn () => new (config('cardano.cardanoServiceProvider')));

        $this->app->singleton(
            'phuffycoinService',
            function () {
                return new PhuffycoinService(
                    $this->app->make(CardanoMintService::class),
                    $this->app->make('cardanoService')
                );
            }
        );
        $this->app->bind(
            PhuffycoinService::class,
            fn ($app) => $app['phuffycoinService']
        );

        $this->app->singleton('CardanoBlockfrostService', CardanoBlockfrostService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
//        Translatable::defaultLocales(
//            collect(
//                config('laravellocalization.supportedLocales')
//            )->keys()->toArray()
//        );
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        Blade::directive('percent', fn ($expression) => (round(((float) $expression) * 100, 3).'%'));
        Blade::directive('markdownLang', function ($expression) {
            return "<?php echo ___($expression); ?>";
        });
        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('Y-m-d'); ?>";
        });
        Lang::macro('hasAny', function ($key, $locales = []) {
            return collect($locales)
                ->map(fn ($locale) => (Lang::has($key, $locale)))
                ->filter()
                ->whereNotNull()
                ->isNotEmpty();
        });

        RateLimiter::for('medialibrary-pro-uploads', function (Request $request) {
            return [
                Limit::perMinute(10)->by($request->ip()),
            ];
        });

        RateLimiter::for('blockfrost', fn () => [
            Limit::perMinute(100),
        ]);

//        Builder::macro('createFilters', function () {
//            return $this->engine()->getTotalCount(
//                $this->engine()->search($this)
//            );
//        });
    }
}
