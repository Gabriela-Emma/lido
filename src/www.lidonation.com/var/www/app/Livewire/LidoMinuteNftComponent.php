<?php

namespace App\Livewire;

use App\Models\Nft;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('A Day at the Lake NFT Series')]
class LidoMinuteNftComponent extends Component
{
    public array|Collection $portraitNfts;

    public array|Collection $inTheLabNfts;

    public array|Collection $bubblesNfts;

    public array|Collection $puddlesNfts;

    public array|Collection $steampunkNfts;

    public array|Collection $tidePoolNfts;

    public array|Collection $behindCurtainNfts;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    public function mount()
    {
        $this->portraitNfts = Nft::inRandomOrder()->whereJsonContains('metadata->motif', 'portrait')->limit(3)->get();
        $this->inTheLabNfts = Nft::inRandomOrder()->whereJsonContains('metadata->motif', 'in the lab')->limit(3)->get();
        $this->bubblesNfts = Nft::inRandomOrder()->whereJsonContains('metadata->motif', 'bubbles')->limit(3)->get();
        $this->puddlesNfts = Nft::inRandomOrder()->whereJsonContains('metadata->motif', 'puddles')->limit(3)->get();
        $this->steampunkNfts = Nft::inRandomOrder()->whereJsonContains('metadata->motif', 'steampunk museum')->limit(3)->get();
        $this->tidePoolNfts = Nft::inRandomOrder()->whereJsonContains('metadata->motif', 'tide pool')->limit(3)->get();
        $this->behindCurtainNfts = Nft::inRandomOrder()->whereJsonContains('metadata->motif', 'behind the curtain')->limit(3)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('livewire.lido-minute-nft');
    }
}
