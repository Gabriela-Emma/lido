<?php

use App\Livewire\Components\BlockchainHeadlinesComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(BlockchainHeadlinesComponent::class)
        ->assertStatus(200);
});
