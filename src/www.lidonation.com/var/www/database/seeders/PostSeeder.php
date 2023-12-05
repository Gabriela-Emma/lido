<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Database\Factories\Traits\UnsplashProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    use WithoutModelEvents , UnsplashProvider;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory(20)
            ->has(Comment::factory()->count(2), 'comments')
            ->create()->each(
            function ($po) {
            $po->addMediaFromUrl($this->getRandomImageLink(2048, 2048))->toMediaCollection('hero');
        });


    }
}
