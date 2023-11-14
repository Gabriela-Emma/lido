<?php

use App\Livewire\CardanoStatsComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(CardanoStatsComponent::class)
        ->assertStatus(200);
});
