<?php

use App\Livewire\GlobalReaction;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(GlobalReaction::class)
        ->assertStatus(200);
});
