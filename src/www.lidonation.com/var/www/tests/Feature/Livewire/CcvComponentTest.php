<?php

use App\Livewire\Earn\CcvComponent;
use App\Models\Nft;
use App\Models\Promo;
use App\Models\User;
use Database\Seeders\NftSeeder;
use Livewire\Livewire;

it('renders successfully', function () {
    $user = User::factory()->create();
    $nft = Nft::factory()->create();
    Promo::factory()->create([
        'user_id' => $user->id,
        'token_id' => $nft->id,
        'title' => 'new promo title',
        'status' => 'published'
    ]);

    Livewire::test(CcvComponent::class)
        ->assertStatus(200);
});
