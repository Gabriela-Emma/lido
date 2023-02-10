<?php

namespace App\Http\View\Composers;

use App\Invokables\GetLidoMenu;
use App\Models\News;
use App\Models\User;
use App\Repositories\AdaRepository;
use App\Repositories\EpochRepository;
use App\Repositories\PoolRepository;
use App\Repositories\PostRepository;
use App\Services\SettingService;
use App\Services\SnippetService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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

    private Collection $lidoMenu;

    /**
     * Create a new profile composer.
     *
     * @param  PostRepository  $posts
     * @param  PoolRepository  $pools
     * @param  EpochRepository  $epochs
     * @param  AdaRepository  $adaRepository
     */
    public function __construct(
        protected PostRepository $posts,
        protected PoolRepository $pools,
        protected EpochRepository $epochs,
        protected AdaRepository $adaRepository
    ) {
        $this->quickNews = $this->posts->setModel(new News)->paginate(6);
        $this->adaQuote = $this->adaRepository->quote();
        $this->user = Auth::user();
        $this->snippets = app(SnippetService::class)->getSnippets();
        $this->settings = app(SettingService::class)->getSettings();
        $this->lidoMenu = (new GetLidoMenu)();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        $view->with([
            'lidoMenu' => $this->lidoMenu,
            'quickNews' => $this->quickNews,
            'adaQuote' => $this->adaQuote,
            'user' => $this->user,
            'snippets' => $this->snippets,
            'settings' => $this->settings,
            'locale' => app()->getLocale(),
            'localeDetail' => new Fluent(config('laravellocalization.supportedLocales.'.app()->getLocale())),
        ]);
    }
}
