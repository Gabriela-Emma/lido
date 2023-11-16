<?php

use App\Livewire\LidoBlockchainLabsComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(LidoBlockchainLabsComponent::class)
        ->assertStatus(200);
});
