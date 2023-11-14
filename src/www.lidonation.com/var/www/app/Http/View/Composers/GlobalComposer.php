<?php

namespace App\Http\View\Composers;

use App\Models\User;
use App\Repositories\AdaRepository;
use App\Repositories\EpochRepository;
use App\Repositories\PoolRepository;
use App\Repositories\PostRepository;
use App\Repositories\SnippetsRepository;
use App\Services\SettingService;
use App\Services\SnippetService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Fluent;
use Illuminate\View\View;

class GlobalComposer
{
    private LengthAwarePaginator $quickNews;

    private ?object $adaQuote;

    private Authenticatable|null|User $user;

    private Fluent $snippets;

    private Fluent $settings;

    /**
     * Create a new profile composer.
     */
    public function __construct(
        protected PostRepository $posts,
        protected PoolRepository $pools,
        protected EpochRepository $epochs,
        protected AdaRepository $adaRepository
    ) {
        $this->user = Auth::user();
        $this->snippets = app(SnippetService::class)->getSnippets();
        $this->settings = app(SettingService::class)->getSettings();
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with([
            'user' => $this->user,
            'snippets' => new SnippetsRepository($this->snippets),
            'settings' => $this->settings,
            'locale' => app()->getLocale(),
            'localeDetail' => new Fluent(config('laravellocalization.supportedLocales.'.app()->getLocale())),
        ]);
    }
}
