<?php

namespace App\Livewire;

use App\Models\CatalystExplorer\Proposal;
use App\Repositories\FundRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ProjectCatalystStats extends Component
{
    public $readyToLoad = false;

    // public $searchQuery = null;
    public ?int $totalProposals;

    public ?int $fundedProposalsCount;

    public ?int $catalystUsersCount;

    public ?int $catalystTeamsCount;

    public function loadStats()
    {
        $this->readyToLoad = true;
    }

    public function render(FundRepository $fundRepository): Factory|View|Application
    {
        if ($this->readyToLoad) {
            $this->totalProposals = $fundRepository
                ->proposalsCount();

            $this->fundedProposalsCount = Proposal::whereNotNull('funded_at')
                ->count();
            $this->fundedProposalsCount = $this->fundedProposalsCount > 0 ? $this->fundedProposalsCount : null;
        }

        return view('livewire.catalyst-stats');
    }
}
