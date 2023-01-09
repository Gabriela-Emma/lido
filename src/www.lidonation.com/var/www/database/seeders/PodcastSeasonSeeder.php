<?php

namespace Database\Seeders;

use App\Models\PodcastSeason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PodcastSeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PodcastSeason::factory()
            ->count(3)
            ->hasEpisodes(22)
            ->forHost()
            ->forShow()
            ->create();
    }
}
