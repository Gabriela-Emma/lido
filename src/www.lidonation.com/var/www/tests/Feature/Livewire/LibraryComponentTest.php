<?php

use App\Livewire\LibraryComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(LibraryComponent::class)
        ->assertStatus(200);
});
