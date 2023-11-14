<?php

use App\Livewire\LidoMinuteNftComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(LidoMinuteNftComponent::class)
        ->assertStatus(200);
});
