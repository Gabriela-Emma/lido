<?php

namespace App\Http\Livewire\ContributeContent;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ContributeContent extends Component
{
    public function render(): Factory|View|Application
    {
        return view(
            'livewire.contribute-content.contribute-content'
        )->layoutData([
            'metaTitle' => 'Contribute Content',
        ]);
    }
}
