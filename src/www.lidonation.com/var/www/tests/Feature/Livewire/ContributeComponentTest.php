<?php

use App\Livewire\Contribute\ContributeComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ContributeComponent::class)
        ->assertStatus(200);
});
