<?php

use App\Livewire\Components\NewToLibrary;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(NewToLibrary::class)
        ->assertStatus(200);
});
