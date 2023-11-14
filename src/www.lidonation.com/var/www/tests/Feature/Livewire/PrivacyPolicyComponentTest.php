<?php

use App\Livewire\PrivacyPolicyComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(PrivacyPolicyComponent::class)
        ->assertStatus(200);
});
