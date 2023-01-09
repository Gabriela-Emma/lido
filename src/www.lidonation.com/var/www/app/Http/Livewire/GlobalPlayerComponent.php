<?php

namespace App\Http\Livewire;

use App\Repositories\FundRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class GlobalPlayerComponent extends Component
{
    public $readyToLoad = false;

    public ?int $totalProposals;

    public function loadStats()
    {
        $this->readyToLoad = true;
    }

    public function render(FundRepository $fundRepository): Factory|View|Application
    {
        return view('livewire.global-player');
    }
}
