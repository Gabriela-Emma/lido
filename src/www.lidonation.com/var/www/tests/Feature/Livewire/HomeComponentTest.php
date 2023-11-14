<?php

use App\Livewire\HomeComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(HomeComponent::class)
        ->assertStatus(200);
});
