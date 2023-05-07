<?php

use Illuminate\Database\Migrations\Migration;
use Tpetry\PostgresqlEnhanced\Schema\Blueprint;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            //@todo update all records to have valid slugs and no nulls before creating index
            //            $table->string('slug')->unique();
            $table->fullText('title');
            $table->fullText('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tags', function (Blueprint $table) {
            //            $table->dropIndex(['slug']);
            $table->dropFullText(['title']);
            $table->dropFullText(['content']);
        });
    }
};
