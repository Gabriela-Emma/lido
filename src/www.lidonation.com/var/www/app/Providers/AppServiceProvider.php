<?php

namespace App\Providers;

use App\Contracts\ProvidesModelExportService;
use App\Models\PersonalAccessToken;
use App\Services\CardanoBlockfrostService;
use App\Services\CardanoMintService;
use App\Services\ExportModelService;
use App\Services\PhuffycoinService;
use App\Services\Providers\ExportModelProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Vinkla\Hashids\Facades\Hashids;

//use Spatie\NovaTranslatable\Translatable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->isLocal() && class_exists(IdeHelperServiceProvider::class)) {
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

        $this->app->bind(ProvidesModelExportService::class, ExportModelProvider::class);
        $this->app->singleton(
            'ExportModelService',
            function () {
                return new ExportModelService(
                    $this->app->make(ProvidesModelExportService::class)
                );
            }
        );
    }

    /**
     * Bootstrap any application services.
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

        RateLimiter::for('vote_history', function (object $job) {
            return Limit::perMinute(15);
        });

        Validator::extend('hashed_exists', function ($attribute, $value, $parameters, $validator) {
            if (is_array($value)) {
                $value = array_map(fn ($item) => (
                    Hashids::connection('App\\Models\\'.Str::studly(Str::singular($parameters[0])))->decode($item)
                ), $value);
            } else {
                $value = Hashids::connection('App\\Models\\'.Str::studly(Str::singular($parameters[0])))->decode($value);
            }

            // Delegate to `exists:` validator
            return $validator->validateExists($attribute, $value, $parameters);
        });

        Str::macro('truncate', fn ($value, $maxLength) => truncate_middle($value, $maxLength));

        //        Builder::macro('createFilters', function () {
        //            return $this->engine()->getTotalCount(
        //                $this->engine()->search($this)
        //            );
        //        });
    }
}
