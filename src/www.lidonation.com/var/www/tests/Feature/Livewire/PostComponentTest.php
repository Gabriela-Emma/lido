<?php

use App\Livewire\Library\PostComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(PostComponent::class)
        ->assertStatus(200);
});
