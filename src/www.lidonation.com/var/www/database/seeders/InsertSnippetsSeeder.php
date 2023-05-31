<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InsertSnippetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $files = [
            'learning-lessons.json',
            'learn-landing_page.json',
        ];

        foreach ($files as $file) {
            $json = File::get(base_path('database/files/' . $file));
            $data = json_decode($json);

            foreach ($data->snippets as $snippet) {
                DB::table('snippets')->insert([
                    'user_id' => 1,
                    'name' => $snippet->heading,
                    'content' => json_encode(['en' => $snippet?->text_en, 'sw' => $snippet?->text_sw, 'es' => '', 'fr' => '', 'zh' => '', 'ja' => '']),
                    'context' => 'global',
                    'type' => 'App\Models\Snippet',
                    'order' => 0,
                    'status' => 'published',
                    'created_at' => date('Y-m-d', time()),
                    'updated_at' => date('Y-m-d', time()),
                ]);
            }
        }
    }
}
