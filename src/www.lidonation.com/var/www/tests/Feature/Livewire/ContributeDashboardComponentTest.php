<?php

use App\Livewire\Contribute\DashboardComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(DashboardComponent::class)
        ->assertStatus(200);
});
