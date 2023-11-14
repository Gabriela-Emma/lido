<?php

use App\Livewire\Partners\PartnerDashboardComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(PartnerDashboardComponent::class)
        ->assertStatus(200);
});
