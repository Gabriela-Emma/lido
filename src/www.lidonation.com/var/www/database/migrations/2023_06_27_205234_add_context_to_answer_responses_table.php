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
        Schema::table('answer_responses', function (Blueprint $table) {
            $table->foreignId('context_id')->nullable();
            $table->text('context_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answer_responses', function (Blueprint $table) {
            $table->removeColumn('context_id');
            $table->removeColumn('context_type');
        });
    }
};
