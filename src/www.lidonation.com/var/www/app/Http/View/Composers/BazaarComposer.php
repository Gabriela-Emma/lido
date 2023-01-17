<?php

namespace App\Http\View\Composers;

use App\Models\Nft;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class BazaarComposer
{
    private array|Collection $latest;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->latest = Nft::inRandomOrder()->limit(7)->get();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'dayAtTheLakeItems' => $this->latest,
            'metaTitle' => 'LIDO Bazaar',
        ]);
    }
}
