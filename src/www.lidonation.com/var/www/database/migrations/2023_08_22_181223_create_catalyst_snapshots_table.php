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
        Schema::create('catalyst_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id');
            $table->text('model_type');
            $table->integer('epoch');
            $table->integer('order');
            $table->timestamp('snapshot_at');

            $table->unique(['model_id', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalyst_snapshots');
    }
};
