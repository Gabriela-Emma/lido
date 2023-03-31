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
        Schema::create('bookmark_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bookmark_collection_id');
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('model_id');
            $table->text('model_type');
            $table->text('title')->nullable();
            $table->text('content')->nullable();
            $table->text('link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookmark_items');
    }
};