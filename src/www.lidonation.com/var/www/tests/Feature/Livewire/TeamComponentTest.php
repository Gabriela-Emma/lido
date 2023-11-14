<?php

use App\Livewire\TeamComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(TeamComponent::class)
        ->assertStatus(200);
});
