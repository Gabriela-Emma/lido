<?php

use App\Livewire\Components\LibraryPostCount;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(LibraryPostCount::class)
        ->assertStatus(200);
});
