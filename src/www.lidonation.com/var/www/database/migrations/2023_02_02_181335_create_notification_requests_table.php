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
        Schema::create('notification_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_request_template_id');
            $table->foreignId('who_id');
            $table->string('who_type');
            $table->foreignId('what_id');
            $table->string('what_type');
            $table->string('when');
            $table->string('where');
            $table->string('status');
            $table->softDeletes();
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
        Schema::dropIfExists('notification_requests');
    }
};
