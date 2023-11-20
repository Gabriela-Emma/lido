<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Partners\LoginComponent;
use Livewire\Livewire;
use Tests\TestCase;

class PartnerLoginComponentTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(LoginComponent::class)
            ->assertStatus(200);
    }
}
