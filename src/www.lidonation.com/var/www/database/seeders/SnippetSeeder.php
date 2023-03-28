<?php

namespace Database\Seeders;

use App\Models\Snippet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

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
  
        $csvFile = fopen(base_path("database/files/snippets.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            
            if (!$firstline) {
                Snippet::create([
                    'user_id' => 1,
                    "name" => $data['0'],
                    'type' => "App\Models\Snippet",
                    "content" => json_encode(['en' => $data['1'], 'es' => '', 'swa' => '', 'fr' => '', 'zh' => '', 'ja' => '']),
                    "context" => 'global',
                    'status' => $faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
                    'order' => 0,
                ]);
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
