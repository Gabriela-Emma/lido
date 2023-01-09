<?php

namespace App\Http\Livewire\Partners;

use App\Models\Nft;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LoginComponent extends Component
{
    public Nft | null $randomNft = null;

    public function mount() {
        $this->randomNft = Nft::inRandomOrder()->first();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.partners.login')->layout('livewire.partners.layout', [
            'metaTitle' => 'LIDO Nation Partners',
        ]);
    }
}
