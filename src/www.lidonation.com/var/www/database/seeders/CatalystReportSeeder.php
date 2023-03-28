<?php

namespace Database\Seeders;

use App\Models\CatalystReport;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CatalystReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
    
        CatalystReport::factory(10)
            ->has(Comment::factory()->count(2), 'comments')
            ->create([
                'project_status' => 'Launched',
                'on_track' => 'Yes'
            ]);

        CatalystReport::factory(10)->create([
            'project_status' => 'Launched',
            'on_track' => 'Yes'
        ]);

        CatalystReport::factory(10)
            ->has(Comment::factory()->count(2), 'comments')    
            ->create([
                'project_status' => 'Still in progress',
                'on_track' => 'Yes'
            ]);

        CatalystReport::factory(10)->create([
            'project_status' => 'Still in progress',
            'on_track' => 'Yes'
        ]);

        CatalystReport::factory(10)
            ->has(Comment::factory()->count(2), 'comments')
            ->create([
                'project_status' => 'Still in progress',
                'on_track' => 'No',
                'off_track_reason' => $faker->sentences(rand(2, 3), true)
            ]);

        CatalystReport::factory(10)->create([
            'project_status' => 'Still in progress',
            'on_track' => 'No',
            'off_track_reason' => $faker->sentences(rand(2, 3), true)
        ]);
    }

}
