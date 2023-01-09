<?php

namespace Database\Seeders;

use App\Models\PodcastShow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PodcastShowSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PodcastShow::factory()
            ->count(5)
            ->hasSeasons(2)
            ->forHost()
            ->forAuthor()
            ->create();
    }
}
