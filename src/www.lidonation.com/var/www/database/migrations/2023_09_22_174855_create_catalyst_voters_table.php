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
        Schema::create('catalyst_voters', function (Blueprint $table) {
            $table->id();
            $table->text('stake_pub');
            $table->text('stake_key');
            $table->text('voting_pub');
            $table->text('voting_key');
            $table->text('cat_id');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['stake_key', 'voting_key', 'cat_id'], 'catalyst_voters_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catalyst_voters', function (Blueprint $table) {
            $table->dropUnique('catalyst_voters_index');
        });
        Schema::dropIfExists('catalyst_voters');

    }
};
