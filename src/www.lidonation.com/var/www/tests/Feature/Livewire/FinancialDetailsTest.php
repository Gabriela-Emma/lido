<?php

use App\Livewire\FinancialDetails;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(FinancialDetails::class)
        ->assertStatus(200);
});
