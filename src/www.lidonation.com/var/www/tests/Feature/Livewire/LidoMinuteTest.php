<?php

use App\Livewire\LidoMinute;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(LidoMinute::class)
        ->assertStatus(200);
});
