<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookmark_items', function (Blueprint $table) {
            $table->smallInteger('action')->nullable()->comment('0: no, 1: yes, 2: abstain');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookmark_items', function (Blueprint $table) {
            $table->dropColumn('action');
        });
    }
};
