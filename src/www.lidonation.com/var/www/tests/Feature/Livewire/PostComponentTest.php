<?php

use App\Livewire\Library\PostComponent;
use App\Models\Post;
use App\Models\Reactions\Reaction;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $post = Post::factory()
        ->for(User::factory()->create())
        ->has(Reaction::factory()->count(3), 'lido_reactions')
        ->create(['title' => 'Fly fly away']);

    Livewire::test(PostComponent::class, ['post' => $post])
        ->assertStatus(200);
});
