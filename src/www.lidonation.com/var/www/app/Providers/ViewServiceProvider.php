<?php

namespace App\Providers;

use App\Http\View\Composers\BazaarComposer;
use App\Http\View\Composers\CatalystChallengeComposer;
use App\Http\View\Composers\CatalystFundComposer;
use App\Http\View\Composers\CatalystGroupComposer;
use App\Http\View\Composers\CatalystUserComposer;
use App\Http\View\Composers\CatalystUsersComposer;
use App\Http\View\Composers\CommunityComposer;
use App\Http\View\Composers\DefinitionsComposer;
use App\Http\View\Composers\GlobalComposer;
use App\Http\View\Composers\GovernanceMarathonComposer;
use App\Http\View\Composers\InsightsComposer;
use App\Http\View\Composers\LidoMinuteComposer;
use App\Http\View\Composers\MeetupComposer;
use App\Http\View\Composers\MintLidoMinuteComposer;
use App\Http\View\Composers\NewsComposer;
use App\Http\View\Composers\Partners\PartnersAppComposer;
use App\Http\View\Composers\PhuffycoinComposer;
use App\Http\View\Composers\PoolComposer;
use App\Http\View\Composers\PostComposer;
use App\Http\View\Composers\PurposeDrivenPoolComposer;
use App\Http\View\Composers\WalletComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CommunityComposer::class);
        $this->app->singleton(GlobalPlayerComposer::class);
        $this->app->singleton(DefinitionsComposer::class);
        $this->app->singleton(InsightsComposer::class);
        $this->app->singleton(MeetupComposer::class);
        $this->app->singleton(NewsComposer::class);
        $this->app->singleton(PurposeDrivenPoolComposer::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Vite::macro('image', fn (string $asset) => $this->asset("resources/images/{$asset}"));
        View::composer('*', GlobalComposer::class);
        View::composer(['phuffycoin'], PhuffycoinComposer::class);
        View::composer(['glossary'], DefinitionsComposer::class);
        View::composer(['insights'], InsightsComposer::class);

        View::composer(['pool-tool'], PoolComposer::class);
        View::composer(['community'], CommunityComposer::class);

        View::composer(['post'], PostComposer::class);
        View::composer(['fund'], CatalystFundComposer::class);
        View::composer(['challenge'], CatalystChallengeComposer::class);
        // Portal
        View::composer(['components.portal.wallets', 'phuffycoin'], WalletComposer::class);

        // Catalysts
        View::composer(['catalyst.users'], CatalystUsersComposer::class);
        View::composer(['catalyst.user'], CatalystUserComposer::class);
        View::composer(['catalyst.group'], CatalystGroupComposer::class);

        // Governance Marathon
        View::composer(['governance-marathon'], GovernanceMarathonComposer::class);

        // Lido Minute
        View::composer(['lido-minute'], LidoMinuteComposer::class);
        View::composer(['lido-minute-nft'], LidoMinuteNftComposer::class);
        View::composer(['mint-lido-minute'], MintLidoMinuteComposer::class);

        // Bazaar
        View::composer(['bazaar'], BazaarComposer::class);

        // Partners
        View::composer(['livewire.partners.app'], PartnersAppComposer::class);
    }
}
