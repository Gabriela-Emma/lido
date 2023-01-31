<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $json=File::get(base_path('database/files/snippets.json'));
        $data=json_decode($json);

        foreach ($data->snippets as $snippet) {

            DB::table('snippets')->insert([
                'user_id' => 1,
                'name' => $snippet->heading,
                'content' => json_encode(['en' => $snippet->text,'es'=>'','swa'=>'','fr'=>'', 'zh'=>'','ja'=>'']),
                'context' => 'global',
                'type' => 'App\Models\Snippet',
                'order' => 0,
                'status' => 'published',
                'created_at' => date('Y-m-d', time()),
                'updated_at' => date('Y-m-d', time()),
            ]);
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};