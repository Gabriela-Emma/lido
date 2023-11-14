<?php

use App\Livewire\LidoMinuteComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(LidoMinuteComponent::class)
        ->assertStatus(200);
});
