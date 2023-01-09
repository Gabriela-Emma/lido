<?php

namespace Database\Seeders;

use App\Models\News;

class NewsSeeder extends PostSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        News::factory(4)
            ->create();

        News::factory(2)
            ->create([
                'prologue' => null,
            ]);

        News::factory(1)
            ->create([
                'epilogue' => null,
            ]);
    }
}
