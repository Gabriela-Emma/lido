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
        Schema::table('users', function (Blueprint $table) {
            $table->text('git')->nullable();
            $table->text('discord')->nullable();
            $table->text('linkedin')->nullable();
            $table->text('telegram')->nullable();
            $table->text('twitter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('git');
            $table->dropColumn('discord');
            $table->dropColumn('linkedin');
            $table->dropColumn('telegram');
            $table->dropColumn('twitter');
        });
    }
};
