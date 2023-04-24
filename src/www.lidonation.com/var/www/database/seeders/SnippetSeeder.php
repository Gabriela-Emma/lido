<?php

namespace Database\Seeders;

use App\Models\Snippet;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class SnippetSeeder extends Seeder
{
    protected $model = Snippet::class;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        Snippet::truncate();

        $csvFile = fopen(base_path('database/files/snippets.csv'), 'r');

        $firstline = true;
        while (($data = fgetcsv($csvFile, 1000, ',')) !== false) {

            if (! $firstline) {
                Snippet::create([
                    'user_id' => 1,
                    'name' => $data['0'],
                    'type' => "App\Models\Snippet",
                    'content' => $data['1'],
                    'context' => 'global',
                    'status' => $faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
                    'order' => 0,
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
