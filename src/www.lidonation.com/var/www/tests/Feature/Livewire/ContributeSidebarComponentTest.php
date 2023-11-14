<?php

use App\Livewire\Contribute\SidebarComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(SidebarComponent::class)
        ->assertStatus(200);
});
