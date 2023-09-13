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
        Schema::create('catalyst_tallies', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('model_id')->unsigned()->nullable();

            $table->text('model_type')->nullable();

            $table->text('hash');

            $table->integer('tally')
                ->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalyst_tallies');
    }
};
