<?php

namespace App\Http\View\Composers;

use App\Models\Podcast;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class LidoMinuteComposer
{
    private array|Collection $latest;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->latest = Podcast::orderBy('published_at')->limit(5)->get();
    }

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'newEpisodes' => $this->latest,
            'metaTitle' => 'LIDO Minute Podcast',
        ]);
    }
}
