<?php

use App\Livewire\ContactLidoComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ContactLidoComponent::class)
        ->assertStatus(200);
});
