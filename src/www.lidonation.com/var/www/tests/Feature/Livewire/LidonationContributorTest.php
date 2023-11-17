<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Contribute\LidonationContributorForm;
use Livewire\Livewire;
use Tests\TestCase;

class LidonationContributorTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(LidonationContributorForm::class)
            ->assertStatus(200);
    }
}
