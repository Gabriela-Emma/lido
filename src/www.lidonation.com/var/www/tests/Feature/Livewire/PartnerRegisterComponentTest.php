<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Partners\RegistrationComponent;
use Livewire\Livewire;
use Tests\TestCase;

class PartnerRegisterComponentTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(RegistrationComponent::class)
            ->assertStatus(200);
    }
}
