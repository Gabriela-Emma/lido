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
        Schema::create('notification_request_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('who_id');
            $table->string('who_type');
            $table->string('what_type');
            $table->json('what_filter');
            $table->string('when');
            $table->string('where');
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
        Schema::dropIfExists('notification_request_templates');
    }
};