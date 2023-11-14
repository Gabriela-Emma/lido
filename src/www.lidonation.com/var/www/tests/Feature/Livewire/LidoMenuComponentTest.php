<?php

use App\Livewire\Components\LidoMenu;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(LidoMenu::class)
        ->assertStatus(200);
});
