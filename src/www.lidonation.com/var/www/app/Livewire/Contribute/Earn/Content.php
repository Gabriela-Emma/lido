<?php

namespace App\Livewire\Contribute\Earn;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.contribute')]
class Content extends Component
{
    public function render()
    {
        return view('livewire.contribute.earn.content');
    }
}
