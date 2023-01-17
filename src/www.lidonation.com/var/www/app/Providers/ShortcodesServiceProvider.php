<?php

namespace App\Providers;

use App\Shortcodes\DefinitionShortcode;
use App\Shortcodes\LinkShortcode;
use App\Shortcodes\ProposalShortcode;
use App\Shortcodes\ProposalsShortcode;
use App\Shortcodes\TweetLinkShortcode;
use Illuminate\Support\ServiceProvider;
use Webwizo\Shortcodes\Facades\Shortcode;

class ShortcodesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        Shortcode::register('proposal', ProposalShortcode::class);
        Shortcode::register('proposals', ProposalsShortcode::class);
        Shortcode::register('link', LinkShortcode::class);
        Shortcode::register('tweet', TweetLinkShortcode::class);
        Shortcode::register('define', DefinitionShortcode::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
