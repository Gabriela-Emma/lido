<?php

namespace App\Livewire\Components;

use App\Models\Nft;
use App\Models\Podcast;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class NftImageGridComponent extends Component
{
    public $dayAtTheLakeItems;

    public function mount()
    {
        $this->dayAtTheLakeItems = Nft::where('model_type', Podcast::class)
                ->where('status', 'minted')
                ->inRandomOrder()
                ->limit(7)->get();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.nft-image-grid');
    }

    public function placeholder(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('components.placeholder.nft-image-grid-placeholder');
    }
}
