<?php

namespace App\Http\Livewire\LidoCatalystProposals;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LidoCatalystProposals extends Component
{
    public ?int $cardanoStakedAddresses;

    public ?int $totalPools;

    public function loadStats()
    {
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.lido-catalyst-proposals.lido-catalyst-proposals')->layoutData(['metaTitle' => 'Lido Catalyst Proposals']);
    }
}
