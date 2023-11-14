<?php

use App\Livewire\Contribute\MyContributionsComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(MyContributionsComponent::class)
        ->assertStatus(200);
});
