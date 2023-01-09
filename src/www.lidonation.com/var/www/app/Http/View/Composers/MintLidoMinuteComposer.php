<?php

namespace App\Http\View\Composers;

use App\Models\Podcast;
use App\Models\Proposal;
use App\Repositories\AdaRepository;
use Carbon\CarbonInterval;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class MintLidoMinuteComposer
{
    private ?object $adaQuote;

    private LengthAwarePaginator $available;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(protected AdaRepository $adaRepository) {
        $this->adaQuote = $this->adaRepository->quote();
        $this->available = Podcast::whereDoesntHave('metas', fn($q) => $q->where('key', '=', 'nft_soldout') )->paginate(6);
    }

    //  Proposal::whereRelation('metas', 'key', '=', 'quick_pitch')
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'adaQuote' => $this->adaQuote,
            'available' => $this->available,
            'metaTitle' => 'Mint LIDO Minute Podcast NFT'
        ]);
    }
}
