<?php

namespace App\Livewire\Partners;

use App\Models\Nft;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ConnectComponent extends Component
{
    public ?Nft $randomNft = null;

    public function mount()
    {
        $this->randomNft = Nft::inRandomOrder()->first();
    }

    #[Layout('layouts.partners')]
    public function render(): Factory|View|Application
    {
        return view('livewire.partners.partners-connect');
    }
}
