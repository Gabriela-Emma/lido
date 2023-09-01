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
        Schema::table('catalyst_voting_powers', function (Blueprint $table) {
            $table->dropColumn('stake_pub');
            $table->text('voter_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catalyst_voting_powers', function (Blueprint $table) {
            $table->dropColumn('voter_id');
            $table->text('stake_pub');
        });
    }
};
