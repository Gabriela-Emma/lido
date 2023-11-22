<?php

use App\Livewire\Components\MorePostsComponent;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(MorePostsComponent::class)
        ->assertStatus(200);
});

it('sets hasMorePages', function () {
    $perPage = 2;

    User::factory()->create(); //Post factory need's an existing user, so we first seed one

    Post::factory()->create(['title' => 'First hasMorePages', 'type' => Post::class, 'status' => 'published']);
    Post::factory()->create(['title' => 'Second hasMorePages', 'type' => Post::class, 'status' => 'published']);
    Post::factory()->create(['title' => 'Third hasMorePages', 'type' => Post::class, 'status' => 'published']);
    Post::factory()->create(['title' => 'Fourth hasMorePages', 'type' => Post::class, 'status' => 'published']);

    $componentInstance = Livewire::test(MorePostsComponent::class, ['perPage' => $perPage]);

    // with 4 posts and perpage set to 2 we expect to have hasMorePages set to true on component load
    $componentInstance->assertSet('hasMorePages', true);

    // assert that on sub-sequent loadMorePosts the hasMorePages variable will be set to null
    $componentInstance->call('loadMorePosts')
        ->assertSet('hasMorePages', false);
});

it('sets offset', function () {
    $offset = 1;
    $perPage = 2;

    User::factory()->create(); //Post factory need's an existing user, so we first seed one

    // seed posts and make sure to set published_at date column, this will help in knowing the order of posts
    $dateToday = Illuminate\Support\Carbon::now();
    Post::factory()->create(['title' => 'Warn costs of South Africa', 'type' => Post::class, 'status' => 'published', 'published_at' => $dateToday->subDays(6)]);
    Post::factory()->create(['title' => 'Testing the first water-pr', 'type' => Post::class, 'status' => 'published', 'published_at' => $dateToday->subDays(5)]);
    Post::factory()->create(['title' => 'Rubber duckies that float', 'type' => Post::class, 'status' => 'published', 'published_at' => $dateToday->subDays(4)]);
    Post::factory()->create(['title' => 'New Axe capital hedge fund', 'type' => Post::class, 'status' => 'published', 'published_at' => $dateToday->subDays(3)]);

    // instanciate the component with pre-defined perpage attribute and an offset of 1 then call loadMorePosts
    // with offset of 1 and perPage of 2 we expect one post and it should be the fourth in order of published_at (DESC)
    Livewire::test(MorePostsComponent::class, ['perPage' => $perPage, 'offset' => $offset])
        ->call('loadMorePosts')
        ->assertCount('posts', 1)
        ->assertSee('New Axe capital hedge fund');
});

it('sets perPage', function () {
    $perPage = 2;

    User::factory()->create(); //Post factory need's an existing user, so we first seed one

    Post::factory()->create(['title' => 'Testing the first water-proof hair dryer', 'type' => Post::class, 'status' => 'published']);
    Post::factory()->create(['title' => 'Rubber duckies that actually float', 'type' => Post::class, 'status' => 'published']);
    Post::factory()->create(['title' => 'The new Axe capital hedge fund', 'type' => Post::class, 'status' => 'published']);
    Post::factory()->create(['title' => 'Warn costs of South Africa', 'type' => Post::class, 'status' => 'published']);

    // instanciate the component with pre-defined perpage attribute
    $componentInstance = Livewire::test(MorePostsComponent::class, ['perPage' => $perPage]);

    // on first load just the paginator is set and no binding of posts
    // Now, load more posts and assert that the posts count increased by the set perPage
    $componentInstance->call('loadMorePosts')
        ->assertCount('posts', $perPage);
});

it('loads more posts with "loadMorePosts()" method', function () {
    $perPage = 2;

    User::factory()->create(); //Post factory need's an existing user, so we first seed one

    Post::factory()->create(['title' => 'Testing the first water-proof hair dryer', 'type' => Post::class, 'status' => 'published']);
    Post::factory()->create(['title' => 'Rubber duckies that actually float', 'type' => Post::class, 'status' => 'published']);
    Post::factory()->create(['title' => 'The new Axe capital hedge fund', 'type' => Post::class, 'status' => 'published']);
    Post::factory()->create(['title' => 'Warn costs of South Africa', 'type' => Post::class, 'status' => 'published']);

    // first execution of loadMorePosts
    $componentInstance = Livewire::test(MorePostsComponent::class)
        ->set('perPage', $perPage)
        ->call('loadMorePosts');

    // asserting posts count on first call of loadMorePosts method
    $componentInstance->assertCount('posts', $perPage);

    // second execution of loadMorePosts method
    $componentInstance->call('loadMorePosts');

    // asserting posts count on second call of loadMorePosts method
    $componentInstance->assertCount('posts', $perPage * 2);
});

it('hides "More Recent Posts" button when no more posts to load', function () {
    $moreLabel = 'More Recent Posts';

    $componentInstance = Livewire::test(MorePostsComponent::class, ['moreLabel' => $moreLabel]);

    //asseting we dont see the label when hasMorePages is set to false
    $componentInstance->set('hasMorePages', false)
        ->assertDontSee($moreLabel);

    //asseting we do see the label when hasMorePages is set to true
    $componentInstance->set('hasMorePages', true)
        ->assertSee($moreLabel);
});
