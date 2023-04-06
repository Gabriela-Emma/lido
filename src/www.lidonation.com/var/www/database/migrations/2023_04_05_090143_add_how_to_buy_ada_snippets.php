<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $json = File::get(base_path('database/files/how-to-buy-ada-onboarding-snippets.json'));
        $data = json_decode($json);

        foreach ($data->snippets as $snippet) {
            DB::table('snippets')->insert([
                'user_id' => 1,
                'name' => $snippet->heading,
                'content' => json_encode(['en' => $snippet->text_en, 'sw' => $snippet->text_sw,'es' => '',  'fr' => '', 'zh' => '', 'ja' => '']),
                'context' => 'global',
                'type' => 'App\Models\Snippet',
                'order' => 0,
                'status' => 'published',
                'created_at' => date('Y-m-d', time()),
                'updated_at' => date('Y-m-d', time()),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('buy_ada_snippets', function (Blueprint $table) {
        //     //
        // });
    }
};
