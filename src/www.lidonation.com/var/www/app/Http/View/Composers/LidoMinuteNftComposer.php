<?php

namespace App\Http\View\Composers;

use App\Models\Nft;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class LidoMinuteNftComposer
{

    private array|Collection $portraitNfts;
    private array|Collection $inTheLabNfts;
    private array|Collection $bubblesNfts;
    private array|Collection $puddlesNfts;
    private array|Collection $steampunkNfts;
    private array|Collection $tidePoolNfts;
    private array|Collection $behindCurtainNfts;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct() {
        $this->portraitNfts = Nft::inRandomOrder()->whereJsonContains('metadata->motif', 'portrait')->limit(3)->get();
        $this->inTheLabNfts = Nft::inRandomOrder()->whereJsonContains('metadata->motif', 'in the lab')->limit(3)->get();
        $this->bubblesNfts = Nft::inRandomOrder()->whereJsonContains('metadata->motif', 'bubbles')->limit(3)->get();
        $this->puddlesNfts = Nft::inRandomOrder()->whereJsonContains('metadata->motif', 'puddles')->limit(3)->get();
        $this->steampunkNfts = Nft::inRandomOrder()->whereJsonContains('metadata->motif', 'steampunk museum')->limit(3)->get();
        $this->tidePoolNfts = Nft::inRandomOrder()->whereJsonContains('metadata->motif', 'tide pool')->limit(3)->get();
        $this->behindCurtainNfts = Nft::inRandomOrder()->whereJsonContains('metadata->motif', 'behind the curtain')->limit(3)->get();
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
            'portraitNfts' => $this->portraitNfts,
            'inTheLabNfts' => $this->inTheLabNfts,
            'bubblesNfts' => $this->bubblesNfts,
            'puddlesNfts' => $this->puddlesNfts,
            'steampunkNfts' => $this->steampunkNfts,
            'tidePoolNfts' => $this->tidePoolNfts,
            'behindCurtainNfts' => $this->behindCurtainNfts,
            'metaTitle' => 'A Day at the Lake NFT Series'
        ]);
    }
}
