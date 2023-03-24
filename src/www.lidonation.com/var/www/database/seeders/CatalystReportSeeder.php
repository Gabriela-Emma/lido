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
        CatalystReport::factory(10)->create([
            'project_status' => 'Launched',
            'on_track' => 'Yes'
        ])->each(function($report) {
            $report->comments()->saveMany(Comment::factory(2)->make()
                // ->map(function ($comment) {
                //     // $comment['commentable_type'] = get_class($report);
                //     // $comment['commentable_id'] = $report->id;

                //     return $comment;
                // })
            );
        });

        CatalystReport::factory(10)->create([
            'project_status' => 'Launched',
            'on_track' => 'Yes'
        ]);

        CatalystReport::factory(10)->create([
            'project_status' => 'Still in progress',
            'on_track' => 'Yes'
        ])->each(function($report) {
            $report->comments()->saveMany(Comment::factory(2)->make());
        });

        CatalystReport::factory(10)->create([
            'project_status' => 'Still in progress',
            'on_track' => 'Yes'
        ]);

        CatalystReport::factory(10)->create([
            'project_status' => 'Still in progress',
            'on_track' => 'No',
            'off_track_reason' => $faker->sentences(rand(2, 3), true)
        ])->each(function($report) {
            $report->comments()->saveMany(Comment::factory(2)->make());
        });

        CatalystReport::factory(10)->create([
            'project_status' => 'Still in progress',
            'on_track' => 'No',
            'off_track_reason' => $faker->sentences(rand(2, 3), true)
        ]);
    }

}
