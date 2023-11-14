<?php

use App\Livewire\BazaarComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(BazaarComponent::class)
        ->assertStatus(200);
});
