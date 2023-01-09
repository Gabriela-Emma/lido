<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory(11)
            ->create();

        Post::factory(3)
            ->create([
                'prologue' => null,
            ]);

        Post::factory(3)
            ->create([
                'epilogue' => null,
            ]);
    }
}
