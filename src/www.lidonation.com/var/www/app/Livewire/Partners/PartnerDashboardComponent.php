<?php

namespace App\Livewire\Partners;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PartnerDashboardComponent extends Component
{
    public $assets = [];

    public $promos = null;

    public function mount(): void
    {
        $this->promos = auth()?->user()?->promos;
    }

    #[Layout('layouts.partners')]
    public function render(): Factory|View|Application
    {
        return view('livewire.partners.dashboard');
    }
}
