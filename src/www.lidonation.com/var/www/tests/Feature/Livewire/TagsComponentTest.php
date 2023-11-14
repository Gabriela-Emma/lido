<?php

use App\Livewire\Tags\TagsComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(TagsComponent::class)
        ->assertStatus(200);
});
