<?php

use App\Livewire\LidoPoolDetails;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    User::factory()->create();
    Post::disableSearchSyncing();
    Post::factory()->create([
        'title' => 'About the Pool',
        'slug' => 'about-the-pool',
        'content' => 'This is the content of the post',
        'status' => 'published',
    ]);
    Livewire::test(LidoPoolDetails::class)
        ->assertStatus(200);
});
