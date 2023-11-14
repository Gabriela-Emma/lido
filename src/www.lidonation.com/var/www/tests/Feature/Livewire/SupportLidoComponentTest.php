<?php

use App\Livewire\Components\SupportLidoComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(SupportLidoComponent::class)
        ->assertStatus(200);
});
