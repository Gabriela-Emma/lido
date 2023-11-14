<?php

use App\Livewire\GlobalSearch\GlobalSearchComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(GlobalSearchComponent::class)
        ->assertStatus(200);
});
