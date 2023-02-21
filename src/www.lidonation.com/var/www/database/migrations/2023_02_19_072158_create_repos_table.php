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
        Schema::create('repos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');
            $table->string('name');
            $table->string('url');
            $table->string('type')->default('git');
            $table->string('tracked_branch');
            $table->boolean('auto_track')->default(true);
            $table->string('deploy_key')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

       public function down()
       {
           Schema::dropIfExists('repos');
       }
};
