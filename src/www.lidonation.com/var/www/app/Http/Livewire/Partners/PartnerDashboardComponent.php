<?php

namespace App\Http\Livewire\Partners;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PartnerDashboardComponent extends Component
{
    public $assets = [];

    public $promos = null;

    public function mount()
    {
        $this->promos = auth()?->user()?->promos;
    }

    public function setAssets($assets)
    {
        dd($assets);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.partners.dashboard')->layout('livewire.partners.layout', [
            'metaTitle' => 'LIDO Nation Partners',
        ]);
    }
}
