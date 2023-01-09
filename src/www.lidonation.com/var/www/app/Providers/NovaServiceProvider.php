<?php

namespace App\Providers;

use App\Models\User;
use App\Nova\Dashboards\Main;
use Illuminate\Support\Facades\Gate;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Parental\Providers\NovaResourceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Nova::sortResourcesBy(function ($resource) {
            return method_exists($resource, 'sortOrder') ?
                $resource::sortOrder() : $resource::label();
        });
//        $this->app->register(NovaResourceProvider::class);
//        $this->app->register(NovaResourceProvider::class);
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function (User $user) {
            return $user->hasRole(['super_admin', 'admin', 'editor', 'super admin', 'contributor']);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    #[Pure]
 protected function dashboards()
 {
     return [
         new Main,
     ];
 }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        Nova::sortResourcesBy(function ($resource) {
//            return $resource::$priority ?? 9999;
//        });
    }

    /**
     * Register the application's Nova resources.
     *
     * @return void
     */
    protected function resources()
    {
        Nova::resourcesIn(app_path('Nova'));
    }
}
