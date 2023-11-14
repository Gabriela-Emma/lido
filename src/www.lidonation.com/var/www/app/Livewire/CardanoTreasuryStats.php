<?php

namespace App\Livewire;

use App\Repositories\FundRepository;
use App\Repositories\ProposalRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CardanoTreasuryStats extends Component
{
    public $readyToLoad = false;

    public int $totalAmount;

    public int $totalProposals;

    public int $fundedProposalsCount;

    public int $totalRounds;

    public function loadStats()
    {
        $this->readyToLoad = true;
    }

    public function render(FundRepository $fundRepository, ProposalRepository $proposalRepository): Factory|View|Application
    {
        if ($this->readyToLoad) {
            $this->totalAmount = $fundRepository
                ->funds('funded')
                ->sum('amount');

            $this->totalRounds = $fundRepository
                ->funds('funded')
                ->count();

            $this->totalProposals = $proposalRepository
                ->count('fundingProposals');

            $this->fundedProposalsCount = $proposalRepository->fundedCount('funded');
        }

        return view('livewire.treasury-stats');
    }
}
