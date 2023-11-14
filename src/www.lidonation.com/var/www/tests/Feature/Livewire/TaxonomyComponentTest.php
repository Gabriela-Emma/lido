<?php

use App\Livewire\Components\TaxonomyComponent;
use App\Models\Category;
use Livewire\Livewire;

// use Mockery;

it('renders successfully', function () {
    $taxonomy = Category::factory()->make([
        'title' => 'first title',
    ]);
    $taxonomy->load(['news', 'reviews', 'insights']);

    Livewire::test(TaxonomyComponent::class, ['taxonomy' => $taxonomy])
        ->assertStatus(200);
});
