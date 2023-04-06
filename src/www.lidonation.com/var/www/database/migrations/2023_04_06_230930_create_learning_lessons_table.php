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
        Schema::create('learning_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('model_id');
            $table->foreignId('model_type');
            $table->string('title');
            $table->string('content');
            $table->integer('number');
            $table->integer('length');
            $table->string('difficulty');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_lessons');
    }
};
