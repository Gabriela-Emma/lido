<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Partners\LoginComponent;

class PartnerLoginComponentTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(LoginComponent::class)
            ->assertStatus(200);
    }
}
