<?php

namespace App\Livewire\CatalystExplorer;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * to index run php artisan ln:index ln__proposals 'funded,over_budget,challenge,fund'
 */
class ProposalComponent extends Component
{
    public Proposal $proposal;
    public function mount(Proposal $proposal): void
    {
        $this->proposal = $proposal;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.proposal');
    }
}
